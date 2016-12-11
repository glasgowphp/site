<?php

namespace Module\Strayobject\FormGenerator;

use Mizzencms\Core\Base;
use Mizzencms\Core\UriParser;
use Mizzencms\Core\Container;
use PFBC\Form;

class FormGenerator extends Base
{
    private $jsonPath;
    private $formSpec;
    private $currentPage;

    public function __construct()
    {
        parent::__construct();

        $this->setJsonPath(
            $this->getBag()->get('basePath')->path.'/config/forms.json'
        );
        $this->setFormSpec(
            json_decode(file_get_contents($this->getJsonPath()), true)
        );
    }
    /**
     * @todo add method to verify if all required data is set in the config
     * @param  string $content
     * @return string
     */
    public function generate($content)
    {
        $this->startSession();
        $currentFormSpec = $this->getFormSpec()[$this->getCurrentPage()];

        if ($_SERVER['REQUEST_METHOD']
            == strtoupper($currentFormSpec['config']['method'])) {
            if (Form::isValid($currentFormSpec['config']['id'])) {
                $formString = $this->successAlertHtmlWrapper(
                    $currentFormSpec['config']['formSuccess']
                );
                /**
                 * @todo  handle this elsewhere
                 */
                $message = 'Form "'.$currentFormSpec['config']['id'].'" has been submitted.'."\n\n";

                foreach ($_POST as $key => $value) {
                    $message .= $key.' : '.filter_var($value, FILTER_SANITIZE_STRING)."\n\n";
                }

                mail('hello@glasgowphp.co.uk', 'New Form Submission', $message);
            } else {
                $formString = $this->createForm()->render(true);
            }
        } else {
            Form::clearErrors($currentFormSpec['config']['id']);
            $formString = $this->createForm()->render(true);
        }

        return str_replace('{form}', $formString, $content);
    }
    public function createForm()
    {
        $currentFormSpec = $this->getFormSpec()[$this->getCurrentPage()];
        $form            = new Form();
        $form->configure($currentFormSpec['config']);

        foreach ($currentFormSpec['fields'] as $field) {
            $params = [];
            $options = [];

            if (isset($field['attr'])) {
                $params = $field['attr'];
            }

            if (isset($field['validate'])) {
                if ($field['validate'] == 'alpha') {
                    $field['validate'] = 'alphaNumeric';
                }

                $validator = '\PFBC\Validation\\'.ucfirst($field['validate']);
                $params['validation'] = new $validator();
            }

            if (isset($field['options'])) {
                $options = $field['options'];
            }

            if ($field['type'] == 'text') {
                $field['type'] = 'textbox';
            } elseif ($field['type'] == 'submit') {
                $field['type'] = 'button';
            }

            $element = '\PFBC\Element\\'.ucfirst($field['type']);

            if (isset($options) && !empty($options)) {
                $el = new $element($field['label'],$field['name'],$options, $params);
            } else {
                $el = new $element($field['label'],$field['name'],$params);
            }

            $form->addElement($el);
        }

        return $form;
    }
    public function successAlertHtmlWrapper($msg)
    {
        return '<div class="alert alert-success">
            <strong class="alert-heading">'.$msg.'</strong></div>';
    }
    /**
     * @todo throw exception if getCurrentPage == null
     * @return boolean [description]
     */
    public function hasFormForPage()
    {
        return isset($this->getFormSpec()[$this->getCurrentPage()]);
    }

    /**
     * Gets the value of jsonPath.
     *
     * @return mixed
     */
    public function getJsonPath()
    {
        return $this->jsonPath;
    }

    /**
     * Sets the value of jsonPath.
     *
     * @param mixed $jsonPath the json path
     *
     * @return self
     */
    public function setJsonPath($jsonPath)
    {
        $this->jsonPath = $jsonPath;

        return $this;
    }

    /**
     * Gets the value of formSpec.
     *
     * @return mixed
     */
    public function getFormSpec()
    {
        return $this->formSpec;
    }

    /**
     * Sets the value of formSpec.
     *
     * @param mixed $formSpec the form spec
     *
     * @return self
     */
    public function setFormSpec($formSpec)
    {
        $this->formSpec = $formSpec;

        return $this;
    }

    /**
     * Gets the value of currentPage.
     *
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Sets the value of currentPage.
     *
     * @param mixed $currentPage the current page
     *
     * @return self
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }
}

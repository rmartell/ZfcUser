<?php

namespace ZfcUser\Form;

use Zend\Form\Form,
    ZfcUser\Module;

class Register extends Base
{
    public function initLate()
    {
        parent::initLate();
//        $this->removeElement('userId');
//        if (!Module::getOption('enable_username')) {
//            $this->removeElement('username');
//        }
        if (!Module::getOption('enable_display_name')) {
            $this->removeElement('display_name');
        }
        if (Module::getOption('registration_form_captcha')) {
           $this->addElement('captcha', 'captcha', array(
                //'label'      => 'Please enter the 5 letters displayed below:',
                'required'   => true,
                'captcha'    => array(
                    'captcha' => 'Figlet',
                    'wordLen' => 5,
                    'timeout' => 300
                ),
                'order'      => 500,
            ));
        }
        $this->setElementDecorators(
                array(
                    'ViewHelper', 
                    array('Errors'),            // for the errors -- need to fix this
                    //array('description',array('tag'=>'span','class'=>'description')),  // for the description to be displayed
                    array(                                       // for the elements Text/Text Area
                        array('data'=>'HtmlTag'),
                        array('tag'=>'div','class'=>'signupElementClass'),
                    ),
                    array('Label',array('tag'=>'div','class'=>'signupLabelClass')),  //for labels
                    array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'signupElementDiv')),  // for the entire element
                
                ),array('submit','captcha'),
                false
            );
        $this->getElement('submit')->setLabel('Register')
                ->setDecorators(array(
                'ViewHelper',
                array(                                       // for the elements Text/Text Area
                        array('data'=>'HtmlTag'),
                        array('tag'=>'div','class'=>'signupElementClass'),
                ),
                array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'signupElementDiv')),  // for the entire element
            ));
    }
}

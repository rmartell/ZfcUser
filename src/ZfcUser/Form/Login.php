<?php

namespace ZfcUser\Form;

use Zend\Form\Form,
    ZfcBase\Form\ProvidesEventsForm,
    ZfcUser\Module as ZfcUser;

class Login extends ProvidesEventsForm
{
    public function init()
    {
        $this->setMethod('post')
             ->loadDefaultDecorators();
       //       ->setDecorators(array('FormErrors') + $this->getDecorators());
        
        $this->clearDecorators();
        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form'))
                             
                
             ->addDecorator('FormDecorator')
                ->addDecorator('FormErrors');
        
        //$this->setElementDecorator()
       
        $this->addElement('text', 'identity', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            ),
            'required'   => true,
            'label'      => 'Email',
        ));
        

        if (ZfcUser::getOption('enable_username')) {
            $emailElement = $this->getElement('identity');
            $emailElement->removeValidator('EmailAddress')
                         ->setLabel('Email or Username'); // @TODO: make translation-friendly
        }
        
        $this->addElement('password', 'credential', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(6, 999))
            ),
            'required'   => true,
            'label'      => 'Password',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore'     => true,
            'decorators' => array('ViewHelper'),
        ));

        $this->addElement('submit', 'login', array(
            'ignore'   => true,
            'label'    => 'Sign In',
            'decorators'=>array(
                'ViewHelper',
                array(                                       // for the elements Text/Text Area
                        array('data'=>'HtmlTag'),
                        array('tag'=>'div','class'=>'signupElementClass','style'=>'width:70%;'),
                ),
                array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'signupElementDiv','style'=>'color: red; padding: 10px; float:right; width: 100%;')),  // for the entire element
            ),
        ));
        
        $this->setElementDecorators(
                array(
                    'ViewHelper', 
                    array('Errors',array('style'=>'color: blue; ')),            // for the errors -- need to fix this
                    //array('description',array('tag'=>'span','class'=>'description')),  // for the description to be displayed
                    array(                                       // for the elements Text/Text Area
                        array('data'=>'HtmlTag'),
                        array('tag'=>'div','class'=>'signupElementClass','style'=>' width: 80%; align:right;'),
                    ),
                    array('Label',array('tag'=>'div','class'=>'signupLabelClass','style'=>'padding-right: 5px; float:left; width: 20%;')),  //for labels
                    array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'signupElementDiv','style'=>'color: red; padding: 10px; float:left; width:100%;')),  // for the entire element
                
                ),array('login'),
                false
            );
        
        $this->events()->trigger('init', $this);
    }
}

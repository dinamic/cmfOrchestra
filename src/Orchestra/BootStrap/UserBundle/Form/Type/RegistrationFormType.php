<?php

namespace BootStrap\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
	private $class;

	/**
	 * @param string $class The User class name
	 */
	public function __construct($class)
	{
		$this->class = $class;
	}

	public function buildForm(FormBuilder $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
	}


	public function getName()
	{
		return 'bootstrap_user_registrationformtype';
	}
}

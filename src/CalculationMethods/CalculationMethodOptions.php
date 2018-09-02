<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 13/07/2018
 * Time: 13:11
 * CalculationMethods metadata access
 */

namespace PTCalculator\CalculationMethods;



use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculationMethodOptions implements CalculationMethodOptionsInterface
{

    /**
     * @var string
     */
    private $label;

    /**
     * @var float
     */
    private $fajrAngle;

    /**
     * @var int
     */
    private $maghribSelector;

    /**
     * @var float
     */
    private $maghribParameterValue;

    /**
     * @var int
     */
    private $ishaSelector;

    /**
     * @var float
     */
    private $ishaParameterValue;

    /**
     * Symfony standalone component :
     * The OptionsResolver component is array_replace on steroids.
     * It allows you to create an options system with required options,
     * defaults, validation (type, value), normalization and more.
     *
     * @var OptionsResolver
     */
    private $resolver;

    /**
     * CalculationMethod constructor.
     */
    public function __construct(){
        $this->resolver = new OptionsResolver();
        $defaultOptions = array(
            'method_name'     => 'default',
            'fajr_angle' => 12, // deg
            'maghrib_selector'     => 1, //(0 = angle; 1 = min after sunset)
            'maghrib_parameter_value' => 0, //(deg or min)
            'isha_selector'     => 0, //(0 = angle; 1 = min after maghrib)
            'isha_parameter_value' => 12, //(deg or min)
        );
        $this->prepareOptions($defaultOptions);
    }

    /**
     * @return float
     */
    public function getFajrAngle(): float
    {
        return $this->fajrAngle;
    }

    /**
     * @return int
     */
    public function getMaghribSelector(): int
    {
        return $this->maghribSelector;
    }

    /**
     * @return float
     */
    public function getMaghribParameterValue(): float
    {
        return $this->maghribParameterValue;
    }

    /**
     * @return int
     */
    public function getIshaSelector(): int
    {
        return $this->ishaSelector;
    }

    /**
     * @return float
     */
    public function getIshaParameterValue(): float
    {
        return $this->ishaParameterValue;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * can configure options if options['method'] === 'custom'
     * @param array $options
     * @return $this
     */
    public function configureOptions(array $options = array()): CalculationMethodOptions
    {
        $this->resolver->resolve($options);
        $this->updateClassParams($options);
        return $this;
    }

    //####################################################################################################
    #########################   CLASS INTERNALS   ########################################################
    ######################################################################################################

    /**
     * Prepare default options
     * @param string $methodName
     * @param array $options
     */
    private function prepareOptions(array $defaultOptions): void
    {

        $this->resolver->setDefaults($defaultOptions);
        $this->resolver->setAllowedTypes('method_name', 'string');
        $this->resolver->setAllowedTypes('fajr_angle', array('int', 'float'));
        $this->resolver->setAllowedTypes('maghrib_selector', array('int'));
        $this->resolver->setAllowedTypes('maghrib_parameter_value', array('int', 'float'));
        $this->resolver->setAllowedTypes('isha_selector', array('int'));
        $this->resolver->setAllowedTypes('isha_parameter_value', array('int', 'float'));
        $this->resolver->setRequired(array(
            'method_name',
            'fajr_angle',
            'maghrib_selector',
            'maghrib_parameter_value',
            'isha_selector',
            'isha_parameter_value',
        ));
        //TODO callable setAllowedValues min-max angle / gps coords for each angles

        $this->updateClassParams($defaultOptions);
    }

    /**
     * @param $values
     */
    private function updateClassParams($values): void
    {
        $this->label = $values['method_name'];
        $this->fajrAngle = $values['fajr_angle'];
        $this->maghribSelector = $values['maghrib_selector'];
        $this->maghribParameterValue = $values['maghrib_parameter_value'];
        $this->ishaSelector = $values['isha_selector'];
        $this->ishaParameterValue = $values['isha_parameter_value'];
    }
}

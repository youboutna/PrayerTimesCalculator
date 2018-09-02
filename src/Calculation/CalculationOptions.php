<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 03/08/2018
 * Time: 12:45
 */

namespace PTCalculator\Calculation;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculationOptions implements CalculationOptionsInterface
{
    /**
     * @var int
     */
    private $asrJuristic;

    /**
     * @var int
     */
    private $numIterations;

    /**
     * @var int
     */
    private $dhuhrMinutes;

    /**
     * @var int
     */
    private $adjust_high_latitudes_method_id;

    /**
     * @var int
     */
    private $time_format_id;

    /**
     * @var OptionsResolver
     */
    private $resolver;

    /**
     * CalculationOptions constructor.
     */
    public function __construct()
    {
        $this->resolver = new OptionsResolver();
        $defaultOptions = array(
            'asr_juristic_method_handler' => 0,
            'number_of_iterations' => 1,
            'dhuhr_minutes_offset' => 0,
            'adjust_high_latitudes_method_handler' => 0,
            'time_format_id_handler' => 0
        );
        $this->prepareOptions($defaultOptions);
    }

    /**
     * @return int
     */
    public function getAsrJuristic(): int
    {
        return $this->asrJuristic;
    }

    /**
     * @return int
     */
    public function getNumIterations(): int
    {
        return $this->numIterations;
    }

    /**
     * @return int
     */
    public function getDhuhrMinutes(): int
    {
        return $this->dhuhrMinutes;
    }

    /**
     * @return int
     */
    public function getAdjustHighLatitudesMethodId(): int
    {
        return $this->adjust_high_latitudes_method_id;
    }

    /**
     * @return int
     */
    public function getTimeFormatId(): int
    {
        return $this->time_format_id;
    }

    /**
     * @return array
     */
    public function getCalcParameters(): array
    {
        return array(
            $this->asrJuristic,
            $this->numIterations,
            $this->dhuhrMinutes,
            $this->adjust_high_latitudes_method_id,
            $this->time_format_id,
        );
    }

    /**
     * can configure options if options['method'] === 'custom'
     * @param array $options
     * @return CalculationOptions
     */
    public function configureOptions(array $options = array()): CalculationOptions
    {

        $this->resolver->resolve($options);
        $this->updateClassParams($options);
        return $this;
    }

//####################################################################################################
    #########################   CLASS INTERNALS   ########################################################
    ######################################################################################################

    /**
     * @param array $defaultOptions
     */
    private function prepareOptions(array $defaultOptions): void
    {
        $this->resolver->setDefaults($defaultOptions);
        $this->resolver->setAllowedTypes('asr_juristic_method_handler', 'int');
        $this->resolver->setAllowedTypes('number_of_iterations', array('int'));
        $this->resolver->setAllowedTypes('dhuhr_minutes_offset', array('int'));
        $this->resolver->setAllowedTypes('adjust_high_latitudes_method_handler', array('int'));
        $this->resolver->setAllowedTypes('time_format_id_handler', array('int'));
        $this->resolver->setAllowedValues('asr_juristic_method_handler', function ($value) {
            if($value < 0 && $value > 1) {
                return 0;
            }else{
                return 1;
            }
        });
        $this->resolver->setRequired(array(
            'asr_juristic_method_handler',
            'number_of_iterations',
            'dhuhr_minutes_offset',
            'adjust_high_latitudes_method_handler',
            'time_format_id_handler'
        ));
        $this->updateClassParams($defaultOptions);
    }

    /**
     * @param $values
     */
    private function updateClassParams($values): void
    {
        $this->asrJuristic = $values['asr_juristic_method_handler'];
        $this->numIterations = $values['number_of_iterations'];
        $this->dhuhrMinutes = $values['dhuhr_minutes_offset'];
        $this->adjust_high_latitudes_method_id = $values['adjust_high_latitudes_method_handler'];
        $this->time_format_id = $values['time_format_id_handler'];
    }
}
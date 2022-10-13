<?php

namespace jigarakatidus;

class CommandLineGenerator
{
    /**
     * Create an instance of Command Line Generator
     *
     * @param string $binary
     * @param string|null $binaryPrefix
     * @param array $arguments
     * @param array $options
     * @param array $flags
     */
    public function __construct(
        private string $binary, 
        private ?string $binaryPrefix = null,
        private array $arguments = [],
        private array $options = [],
        private array $flags = [],
    )
    {
        
    }

    /**
     * Add Option
     *
     * @param string $option
     * @param string $value
     * @return void
     */
    public function addOption(string $option, string $value): void
    {
        $this->options[$option][] = $value;
    }

    /**
     * Add Flag
     *
     * @param string $flag
     * @return void
     */
    public function addFlag(string $flag): void
    {
        $this->flags[] = $flag;
    }

    /**
     * Add Argument
     *
     * @param string $argument
     * @return void
     */
    public function addArgument(string $argument): void
    {
        $this->arguments[] = $argument;
    }

    /**
     * Print options
     *
     * @return string
     */
    private function printOptions(): string
    {
        $options = "";
        foreach($this->options as $option => $values){
            foreach($values as $value){
                if(strlen($option) > 1){
                    $options .= sprintf("--%s='%s' ", $option, $value);
                } else {
                    $options .= sprintf("-%s '%s' ", $option, $value);
                }
            }
        }
        return trim($options);
    }

    /**
     * Print flags
     *
     * @return string
     */
    private function printFlags(): string
    {
        $flags = "";
        foreach($this->flags as $flag){
            $hyphenStyle = strlen($flag) > 1 ? "--" : "-";
            $flags .= sprintf("%s%s ", $hyphenStyle, $flag);
        }
        return trim($flags);
    }

    /**
     * Print arguments
     *
     * @return string
     */
    private function printArguments(): string
    {
        $arguments = "";
        foreach($this->arguments as $argument){
            $arguments .= sprintf("'%s' ", $argument);
        }
        return trim($arguments);
    }

    /**
     * Generate the Command Line
     *
     * @return string
     */
    public function generate(): string
    {
        $binary = $this->binaryPrefix ? $this->binaryPrefix.$this->binary : $this->binary;
        $options = $this->printOptions();
        $flags = $this->printFlags();
        $arguments = $this->printArguments();
        return str_replace('  ', ' ', sprintf('%s %s %s %s', $binary, $options, $flags, $arguments));
    }
}

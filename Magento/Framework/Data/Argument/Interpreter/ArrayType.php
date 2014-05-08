<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
namespace Magento\Framework\Data\Argument\Interpreter;

use Magento\Framework\Data\Argument\InterpreterInterface;

/**
 * Interpreter of array data type that supports arrays of unlimited depth
 */
class ArrayType implements InterpreterInterface
{
    /**
     * Interpreter of individual array item
     *
     * @var InterpreterInterface
     */
    private $itemInterpreter;

    /**
     * @param InterpreterInterface $itemInterpreter
     */
    public function __construct(InterpreterInterface $itemInterpreter)
    {
        $this->itemInterpreter = $itemInterpreter;
    }

    /**
     * {@inheritdoc}
     * @return array
     * @throws \InvalidArgumentException
     */
    public function evaluate(array $data)
    {
        if (!isset($data['item']) || !is_array($data['item'])) {
            throw new \InvalidArgumentException('Array items are expected.');
        }
        $result = array();
        $items = $data['item'];
        foreach ($items as $itemKey => $itemData) {
            $result[$itemKey] = $this->itemInterpreter->evaluate($itemData);
        }
        return $result;
    }
}

<?php

declare(strict_types=1);

namespace Seara\Service\Core\Transformation;

class ArrayTransformer
{
    public function transform(array $input, array $transformations): array
    {
        $output = [];
        foreach ($input as $key => $value) {
            $output[$key] = $this->apply($key, $value, $transformations);
        }
        return $output;
    }

    private function apply($key, $value, array $transformations)
    {
        $transformation = $this->getTransformation($key, $transformations);
        return $transformation($value);
    }

    private function getTransformation($key, array $transformations)
    {
        if (
            array_key_exists($key, $transformations)
        ) {
            return is_callable($transformations[$key])
                ? $transformations[$key]
                : $this->stackTransformations($transformations[$key]);
        }

        return function ($input) {
            return $input;
        };
    }

    private function stackTransformations(array $operations)
    {
        return function ($input) use ($operations) {
            $output = $input;
            foreach ($operations as $operation) {
                $output = $operation($output);
            }
            return $output;
        };
    }
}

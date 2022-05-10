<?php

namespace Seara\Http\Requests;

use Seara\Service\Core\Transformation\ArrayTransformer;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * @var ArrayTransformer
     */
    private $transformer;

    public function __construct(
        array $query = array(),
        array $request = array(),
        array $attributes = array(),
        array $cookies = array(),
        array $files = array(),
        array $server = array(),
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->transformer = new ArrayTransformer();
    }

    public function response(array $errors)
    {
        $errorData = [
            'status' => 'error',
            'message' => array_flatten($errors)
        ];
        return parent::response($errorData);
    }

    protected function transform(array $transformations)
    {
        $transformedRequest = $this->transformer->transform(
            $this->all(),
            $transformations
        );
        $this->merge($transformedRequest);
    }
}

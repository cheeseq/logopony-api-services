<?php


namespace App\Applications;


use Rakit\Validation\Validator;

abstract class AbstractApplication
{
    protected array $config;
    protected array $request;

    public function __construct(array $config, array $request)
    {
        $validator = new Validator();
        $configValidation = $validator->validate($config, $this->getConfigValidationRules($validator));
        if ($configValidation->fails()) {
            throw new InvalidConfigException(implode(', ', $configValidation->errors()->all()));
        }
        $requestValidation = $validator->validate($request, $this->getRequestValidationRules($validator));
        if ($requestValidation->fails()) {
            throw new InvalidRequestException(implode(', ', $requestValidation->errors()->all()));
        }
        $this->config = $config;
        $this->request = $request;
    }

    abstract protected function getConfigValidationRules(Validator $validator): array;

    abstract protected function getRequestValidationRules(Validator $validator): array;
}
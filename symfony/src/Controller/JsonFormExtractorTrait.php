<?php

namespace App\Controller;

use App\Exception\FormException;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait JsonFormExtractorTrait
{
    private ValidatorInterface $validator;

    /**
     * @required
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @param string|resource    $json
     * @param array<string>|null $groups
     *
     * @throws FormException
     */
    private function extract(string $class, mixed $json, ?array $groups = null): mixed
    {
        if ('' === $json) {
            throw new FormException(['No content provided']);
        }

        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);

        $encoders = [new JsonEncoder()];
        $normalizers = [
            new DateTimeNormalizer(),
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, $extractor),
        ];

        $serializer = new Serializer($normalizers, $encoders);

        try {
            $object = $serializer->deserialize($json, $class, 'json');
        } catch (NotEncodableValueException | NotNormalizableValueException $exception) {
            throw new FormException([$exception->getMessage()]);
        }

        return $this->validate($object, $groups);
    }

    /**
     * @param mixed      $object
     * @param array|null $groups
     *
     * @return mixed
     * @throws FormException
     */
    private function validate(mixed $object, ?array $groups): mixed
    {
//        if (isset($this->validator)) {
            $violations = $this->validator->validate($object, null, $groups);

            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }

                throw new FormException($errors, 'There are errors in the provided json');
            }
//        }

        return $object;
    }
}

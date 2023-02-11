<?php

namespace Auth\SignedRequest\Classes;

class Signature
{
    /**
     * @param array $data
     * @param string $string
     * @return string
     */
    protected function prepareData(array $data, string &$string=''): string
    {
        ksort($data);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->prepareData($value, $string);
            } else {
                $string .= "$key=$value";
            }
        }

        return $string;
    }

    /**
     * @param array $data
     * @return string
     */
    public function create(array $data): string
    {
        $signatureString = $this->prepareData($data);

        $signatureKey =  config('auth-signature.key');

        $signatureString = $signatureKey . $signatureString . $signatureKey;

        return hash(config('auth-signature.sha_type'), $signatureString);
    }

    /**
     * @param array $data
     * @param string $signature
     * @return bool
     */
    protected function verify(array $data , string $signature): bool
    {
        $dataSignature = $this->create($data);

        return $dataSignature == $signature;
    }

    /**
     * @param array $data
     * @param string $signature
     * @throws \Exception
     */
    public function validate(array $data , string $signature)
    {
        if (!$this->verify($data, $signature)) {
            throw new \Exception('Mismatch signature');
        }
    }
}
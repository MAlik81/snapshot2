<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;

class RekognitionService
{
    protected $rekognitionClient;

    public function __construct()
    {
        $this->rekognitionClient = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    public function createCollection($collectionId)
    {
        try {
            $result = $this->rekognitionClient->createCollection([
                'CollectionId' => $collectionId,
            ]);
            
            return $result;
        } catch (\Exception $e) {
            // Handle the error accordingly
            return false;
        }
    }
}

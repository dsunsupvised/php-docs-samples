<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/language/README.md
 */

# [START language_entity_sentiment_gcs]
namespace Google\Cloud\Samples\Language;

use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;
use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Entity\Type as EntityType;

/**
 * Find the entities in text.
 * ```
 * analyze_entity_sentiment_from_file('gs://storage-bucket/file-name');
 * ```
 *
 * @param string $gcsUri Your Cloud Storage bucket URI
 * @param string $projectId (optional) Your Google Cloud Project ID
 *
 */

function analyze_entity_sentiment_from_file($gcsUri, $projectId = null)
{
    // Create the Natural Language client
    $languageServiceClient = new LanguageServiceClient(['projectId' => $projectId]);
    try {
        // Create a new Document
        $document = new Document();
        // Pass GCS URI and set document type to PLAIN_TEXT
        $document->setGcsContentUri($gcsUri)->setType(Type::PLAIN_TEXT);
        // Call the analyzeEntitySentiment function
        $response = $languageServiceClient->analyzeEntitySentiment($document);
        $entities = $response->getEntities();
        // Print out information about each entity
        foreach ($entities as $entity) {
            printf('Entity Name: %s' . PHP_EOL, $entity->getName());
            printf('Entity Type: %s' . PHP_EOL, EntityType::name($entity->getType()));
            printf('Entity Salience: %s' . PHP_EOL, $entity->getSalience());
            $sentiment = $entity->getSentiment();
            if ($sentiment) {
                printf('Entity Magnitude: %s' . PHP_EOL, $sentiment->getMagnitude());
                printf('Entity Score: %s' . PHP_EOL, $sentiment->getScore());
            }
            print(PHP_EOL);
        }
    } finally {
        $languageServiceClient->close();
    }
}
# [END language_entity_sentiment_gcs]

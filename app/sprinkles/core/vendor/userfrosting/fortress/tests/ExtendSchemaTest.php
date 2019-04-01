<?php

use PHPUnit\Framework\TestCase;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\Fortress\RequestSchema\RequestSchemaRepository;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;
use UserFrosting\Support\Repository\PathBuilder\StreamPathBuilder;

class ExtendSchemaTest extends TestCase
{
    protected $basePath;

    protected $locator;

    public function setUp()
    {
        $this->basePath = __DIR__ . '/data';

        // Arrange
        $this->locator = new ResourceLocator($this->basePath);

        $this->locator->registerStream('schema');

        // Add them one at a time to simulate how they are added in SprinkleManager
        $this->locator->registerLocation('core');
        $this->locator->registerLocation('account');
        $this->locator->registerLocation('admin');
    }

    public function testExtendYamlSchema()
    {
        // Arrange
        $builder = new StreamPathBuilder($this->locator, 'schema://contact.yaml');
        $loader = new YamlFileLoader($builder->buildPaths());
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $result = $schema->all();

        // Assert
        $this->assertEquals([
            "name" => [
                "validators" => [
                    "length" => [
                        "min" => 1,
                        "max" => 200,
                        "message" => "Please enter a name between 1 and 200 characters."
                    ],
                    "required" => [
                        "message" => "Please specify your name."
                    ]
                ]
            ],
            "email" => [
                "validators" => [
                    "length" => [
                        "min" => 1,
                        "max" => 150,
                        "message" => "Please enter an email address between 1 and 150 characters."
                    ],
                    "email" => [
                        "message" => "That does not appear to be a valid email address."
                    ],
                    "required" => [
                        "message" => "Please specify your email address."
                    ]
                ]
            ],
            "message" => [
                "validators" => [
                    "required" => [
                        "message" => "Please enter a message"
                    ]
                ]
            ]
        ], $result);
    }
}

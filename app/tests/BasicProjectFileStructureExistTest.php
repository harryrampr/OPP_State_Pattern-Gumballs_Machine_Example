<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class TestContainerNeededFilesExist
 *
 * Test case to verify the existence of necessary folders and files at the project.
 */
class BasicProjectFileStructureExistTest extends TestCase
{
    /**
     * Test if the app directory exists at the root of the project.
     *
     * @return void
     */
    public function testAppDirectoryExists(): void
    {
        $filePath = __DIR__ . '/../../app';
        $this->assertDirectoryExists($filePath);
    }

    /**
     * Test if the .gitignore file exists at the root of the project.
     *
     * @return void
     */
    public function testDotGitIgnoreFileExists(): void
    {
        $filePath = __DIR__ . '/../../.gitignore';
        $this->assertFileExists($filePath);
    }

    /**
     * Test if the composer.json file exists at the root of the project.
     *
     * @return void
     */
    public function testComposerJsonFileExists(): void
    {
        $filePath = __DIR__ . '/../../composer.json';
        $this->assertFileExists($filePath);
    }

}
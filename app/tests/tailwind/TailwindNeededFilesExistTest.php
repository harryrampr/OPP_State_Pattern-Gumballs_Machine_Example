<?php
declare(strict_types=1);

namespace Tests\tailwind;

use PHPUnit\Framework\TestCase;

/**
 * Class TestContainerNeededFilesExist
 *
 * Test case to verify the existence of necessary folders and files to use Tailwind.
 */
class TailwindNeededFilesExistTest extends TestCase
{
    /**
     * Test if the tailwind.config.js file exists at the root of the project.
     *
     * @return void
     */
    public function testTailwindConfigFileExists(): void
    {
        $filePath = __DIR__ . '/../../../tailwind.config.js';
        $this->assertFileExists($filePath);
    }

    /**
     * Test if the tailwind_input.css file exists at /app/src/css directory
     *
     * @return void
     */
    public function testTailwindInputFileExists(): void
    {
        $filePath = __DIR__ . '/../../src/css/tailwind_input.css';
        $this->assertFileExists($filePath);
    }

    /**
     * Test if the main.css file exists at /app/public/css directory
     *
     * @return void
     */
    public function testMainCssFileExists(): void
    {
        $filePath = __DIR__ . '/../../public/css/main.css';
        $this->assertFileExists($filePath);
    }

    /**
     * Test if the package.json file exists at the root of the project.
     *
     * @return void
     */
    public function testPackageJsonFileExists(): void
    {
        $filePath = __DIR__ . '/../../../package.json';
        $this->assertFileExists($filePath);
    }

    /**
     * Test if the node_modules directory exists at the root of the project.
     *
     * @return void
     */
    public function testNodeModulesDirectoryExists(): void
    {
        $filePath = __DIR__ . '/../../../node_modules';
        $this->assertDirectoryExists($filePath);
    }
}
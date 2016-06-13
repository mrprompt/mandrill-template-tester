<?php
namespace MrPrompt\Tests\Mandrill\Console\Template;

use MrPrompt\Mandrill\Console\Template\TemplateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class TemplateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TemplateCommand
     */
    private $command;

    /**
     * Bootstrap
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $container   = require __DIR__ . '/../bootstrap.php';

        $application = new Application();
        $application->add(new TemplateCommand('template:test', $container));

        $this->command = $application->find('template:test');
    }

    /**
     * Shutdown
     *
     * @return void
     */
    public function tearDown()
    {
        $this->command = null;

        parent::tearDown();
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Console\Exception\RuntimeException
     */
    public function runCommandWithoutArgumentThrowsRunTineException()
    {
        $command = $this->command;

        $tester = new CommandTester($command);
        $tester->execute(['command' => $command->getName()]);

        $this->assertNotEmpty($tester->getDisplay());
    }

    /**
     * @test
     * @expectedException \Mandrill_Unknown_Template
     */
    public function runCommandWithValidArgumentsMustBeRunCorrectly()
    {
        $command = $this->command;

        $tester = new CommandTester($command);
        $tester->execute([
            'command'   => $command->getName(),
            'template'  => '00-00-00-00',
            'email'     => 'foo@foobar.bar',
            'from'      => 'foo@foobar.bar',
        ]);

        $this->assertNotEmpty($tester->getDisplay());
    }

    /**
     * @test
     * @expectedException \Mandrill_Unknown_Template
     */
    public function runCommandWithValidArgumentsAnddSubstitutionsMustBeRunCorrectly()
    {
        $command = $this->command;

        $tester = new CommandTester($command);
        $tester->execute([
            'command'   => $command->getName(),
            'template'  => '00-00-00-00',
            'email'     => 'foo@foobar.bar',
            'from'      => 'foo@foobar.bar',
            'tags'      => ['foo:bar'],
        ]);

        $this->assertNotEmpty($tester->getDisplay());
    }
}
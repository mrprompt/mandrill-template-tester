<?php
namespace MrPrompt\Mandrill\Console\Template;

use Mandrill;
use Mandrill_Messages;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class TemplateCommand extends Command
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('template:test')
            ->setDescription('Sent email using template')
            ->addArgument('template', InputArgument::REQUIRED, 'Template ID')
            ->addArgument('email', InputArgument::REQUIRED, 'Email to sent')
            ->addArgument('from', InputArgument::REQUIRED, 'Email sender')
            ->addArgument('tags', InputArgument::IS_ARRAY, 'Substitutions used in template', [])
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $apiKey     = getenv('MANDRILL_API_KEY');
        $to         = $input->getArgument('email');
        $template   = $input->getArgument('template');
        $tags       = $input->getArgument('tags');
        $from       = $input->getArgument('from');
        $substitutions = [];

        foreach ($tags as $tag) {
            list($item, $content) = explode(':', $tag);

            $substitutions[$item] = [$content];
        }

        $content = [
            'html' => __CLASS__,
            'text' => __CLASS__,
            'from_email' => $from,
            'subject' => 'Template Test #' . uniqid(),
            'to' => [
                'to' => [
                    'email' => $to
                ]
            ]
        ];

        $sender = new Mandrill($apiKey);

        $message = new \Mandrill_Messages($sender);
        $result = $message->sendTemplate($template, $substitutions, $content);

        if (!array_key_exists(0, $result)) {
            $output->writeln('<error>unknown error... :(</error>');

            return false;
        }

        if ($result[0]['status'] === 'sent') {
            $output->writeln('<info>:)</info>');

            return true;
        }

        $output->writeln('<error>' . $result[0]['reject_reason'] . '</error>');
    }
}

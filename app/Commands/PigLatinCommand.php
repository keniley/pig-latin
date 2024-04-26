<?php

namespace App\Commands;

use App\Interfaces\TranslatorInterface;
use App\Services\Translator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:translate',
    description: 'Translate text by Pig Latin',
)]
class PigLatinCommand extends Command
{
    protected TranslatorInterface $translator;

    public function __construct()
    {
        parent::__construct();
        $this->translator = new Translator();
    }

    // configure the command
    protected function configure(): void
    {
        $this->addOption(
            'iterations',
            // this is the optional shortcut of the option name, which usually is just a letter
            // (e.g. `i`, so users pass it as `-i`); use it for commonly used options
            // or options with long names
            null,
            // this is the type of option (e.g. requires a value, can be passed more than once, etc.)
            InputOption::VALUE_REQUIRED,
            // the option description displayed when showing the command help
            'How many times should the message be printed?',
            // the default value of the option (for those which allow to pass values)
            1
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $compoundWordsQuestion = new ChoiceQuestion(
            'Please choose how to detect compound words (default camelCase)',
            // choices can also be PHP objects that implement __toString() method
            ['camelCase', 'snake_case', 'ai'],
            0
        );
        $compoundWordsQuestion->setErrorMessage('Color %s is invalid.');

        $type = $helper->ask($input, $output, $compoundWordsQuestion);
        $output->writeln('You have just selected: ' . $type);

        $question = new Question('Please enter the word to translate: ', '');

        $question->setValidator(function ($answer): string {
            if (!is_string($answer) || empty($answer)) {
                throw new \RuntimeException(
                    'The word is not set!'
                );
            }

            if (str_contains($answer, ' ')) {
                throw new \RuntimeException(
                    'You can set only one word!'
                );
            }
            return $answer;
        });

        $question->setMaxAttempts(2);

        $text = $helper->ask($input, $output, $question);

        try {
            $this->translate($text, $type, $output);
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    protected function translate(string $word, string $type, OutputInterface $output): void
    {
        $translated = $this->translator->translate($word, $type);
        $output->writeln($translated);
    }
}
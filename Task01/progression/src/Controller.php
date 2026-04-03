<?php

namespace Student\Progression\Controller;

use function Student\Progression\View\showWelcome;
use function Student\Progression\View\showProgression;
use function Student\Progression\View\showSuccess;
use function Student\Progression\View\showFailure;
use function Student\Progression\View\showBye;

function generateProgression(): array
{
    $start = random_int(1, 50);
    $step  = random_int(1, 20);
    $progression = [];
    for ($i = 0; $i < 10; $i++) {
        $progression[] = $start + $step * $i;
    }
    return $progression;
}

function buildQuestion(array $progression): array
{
    $hiddenIndex = random_int(0, 9);
    $answer = $progression[$hiddenIndex];
    $display = $progression;
    $display[$hiddenIndex] = '...';
    return [$display, $answer, $hiddenIndex];
}

function startGame(): void
{
    showWelcome();

    $name = \cli\prompt("Введите ваше имя");
    \cli\line("Привет, $name!");
    \cli\line("");

    $rounds = 3;
    $score  = 0;

    for ($round = 1; $round <= $rounds; $round++) {
        \cli\line("--- Раунд $round из $rounds ---");

        $progression = generateProgression();
        [$display, $answer] = buildQuestion($progression);

        showProgression($display);

        $input = \cli\prompt("Ваш ответ");

        if ((int)$input === $answer) {
            showSuccess();
            $score++;
        } else {
            showFailure($answer, $progression);
        }
        \cli\line("");
    }

    \cli\line("Результат: $score из $rounds");
    showBye();
}

<?php

namespace Student\Progression\View;

function showWelcome(): void
{
    \cli\line("=================================");
    \cli\line("  Игра 'Арифметическая прогрессия'");
    \cli\line("=================================");
    \cli\line("Вам будет показан ряд из 10 чисел,");
    \cli\line("образующих арифметическую прогрессию.");
    \cli\line("Одно число заменено точками (...).");
    \cli\line("Ваша задача — назвать пропущенное число.");
    \cli\line("");
}

function showProgression(array $progression): void
{
    \cli\line("Прогрессия: " . implode(', ', $progression));
}

function showSuccess(): void
{
    \cli\line("Правильно! Поздравляем!");
}

function showFailure(int $correctAnswer, array $fullProgression): void
{
    \cli\line("Неправильно. Правильный ответ: " . $correctAnswer);
    \cli\line("Полная прогрессия: " . implode(', ', $fullProgression));
}

function showBye(): void
{
    \cli\line("");
    \cli\line("Спасибо за игру! До свидания!");
}

<?php

namespace App\Enums;

use Rea\LaravelEnumsPlus\EnumPlus;
use Rea\LaravelEnumsPlus\IsEnumPlus;

enum SusEnum: string implements EnumPlus
{
    use IsEnumPlus;

    case QUESTION_1 = 'question_1';
    case QUESTION_2 = 'question_2';
    case QUESTION_3 = 'question_3';
    case QUESTION_4 = 'question_4';
    case QUESTION_5 = 'question_5';
    case QUESTION_6 = 'question_6';
    case QUESTION_7 = 'question_7';
    case QUESTION_8 = 'question_8';
    case QUESTION_9 = 'question_9';
    case QUESTION_10 = 'question_10';

    #region EnumPlus

    public function translations(): array
    {
        return [
            'de' => [
                self::QUESTION_1->value => 'Ich denke, dass ich dieses Produkt häuﬁg verwenden möchte.',
                self::QUESTION_2->value => 'Ich fand das Produkt unnötig komplex.',
                self::QUESTION_3->value => 'Ich dachte, das Produkt war einfach zu bedienen.',
                self::QUESTION_4->value => 'Ich denke, dass ich die Unterstützung einer technischen Person brauche, um dieses Produkt nutzen zu können.',
                self::QUESTION_5->value => 'Ich fand, die verschiedenen Funktionen in diesem Produkt waren gut integriert.',
                self::QUESTION_6->value => 'Ich dachte, dass dieses Produkt nicht konsistent genug war.',
                self::QUESTION_7->value => 'Ich würde mir vorstellen, dass die meisten Leute sehr schnell lernen würden, dieses Produkt zu benutzen.',
                self::QUESTION_8->value => 'Ich fand dieses Produkt sehr umständlich zu benutzen.',
                self::QUESTION_9->value => 'Ich habe mich sehr selbstsicher gefühlt, dieses Produkt zu verwenden.',
                self::QUESTION_10->value => 'Ich musste eine Menge Dinge lernen, bevor ich mit diesem Produkt loslegen konnte.',
            ],
        ];
    }

    #endregion EnumPlus
}

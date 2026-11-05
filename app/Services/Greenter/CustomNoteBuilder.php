<?php

namespace App\Services\Greenter;

use Greenter\Model\TimeZonePe;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Filter\FormatFilter;
use Greenter\Xml\Filter\TributoFunction;
use Twig\Environment;
use Twig\Extension\CoreExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CustomNoteBuilder extends NoteBuilder
{
    public function __construct(array $options = [])
    {
        $templateDirs = [
            resource_path('views/greenter_templates'),
            base_path('vendor/greenter/greenter/packages/xml/src/Xml/Templates')
        ];

        $loader = new FilesystemLoader($templateDirs);
        $this->twig = new Environment($loader, array_merge(['autoescape' => false], $options));

        $extension = $this->twig->getExtension(CoreExtension::class);
        if ($extension instanceof CoreExtension) {
            $extension->setTimezone(TimeZonePe::DEFAULT);
        }

        $formatFilter = new FormatFilter();
        $this->twig->addFilter(new TwigFilter('n_format', [$formatFilter, 'number']));
        $this->twig->addFilter(new TwigFilter('n_format_limit', [$formatFilter, 'numberLimit']));
        $this->twig->addFunction(new TwigFunction('getTributoAfect', [TributoFunction::class, 'getByAfectacion']));
    }
}

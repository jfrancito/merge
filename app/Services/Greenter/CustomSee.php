<?php

namespace App\Services\Greenter;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Note;
use Greenter\See;
use ReflectionClass;

class CustomSee extends See
{
    public function send(DocumentInterface $document): ?\Greenter\Model\Response\BaseResult
    {
        $this->configureCustomFactory(get_class($document));

        if ($document instanceof Note) {
            $this->getFactory()->setBuilder(new CustomNoteBuilder());
        }

        return $this->getFactory()->send($document);
    }

    public function getXml(DocumentInterface $document): ?string
    {
        $this->configureCustomFactory(get_class($document));

        if ($document instanceof Note) {
            $this->getFactory()->setBuilder(new CustomNoteBuilder());
        }

        return $this->getFactory()->getXml($document);
    }

    private function configureCustomFactory(string $docClass): void
    {
        $reflection = new ReflectionClass(See::class);
        $method = $reflection->getMethod('configureFactory');
        $method->setAccessible(true);
        $method->invoke($this, $docClass);
    }
}

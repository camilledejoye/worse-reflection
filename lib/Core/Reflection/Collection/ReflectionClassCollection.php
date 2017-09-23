<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor\WorseReflection\Core\ServiceLocator;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Microsoft\PhpParser\Node\SourceFileNode;
use Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor\WorseReflection\Core\Reflection\ReflectionInterface;
use Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor\WorseReflection\Core\Reflection\ReflectionTrait;
use Phpactor\WorseReflection\Core\SourceCode;

/**
 * @method \Phpactor\WorseReflection\Core\Reflection\ReflectionClass get()
 */
class ReflectionClassCollection extends AbstractReflectionCollection
{
    public static function fromSource(ServiceLocator $serviceLocator, SourceCode $source)
    {
        $node = $serviceLocator->parser()->parseSourceFile((string) $source);

        $items = [];

        foreach ($node->getChildNodes() as $child) {
            if (
                false === $child instanceof ClassDeclaration &&
                false === $child instanceof InterfaceDeclaration &&
                false === $child instanceof TraitDeclaration
            ) {
                continue;
            }

            if ($child instanceof TraitDeclaration) {
                $items[(string) $child->getNamespacedName()] =  new ReflectionTrait($serviceLocator, $source, $child);
                continue;
            }

            if ($child instanceof InterfaceDeclaration) {
                $items[(string) $child->getNamespacedName()] =  new ReflectionInterface($serviceLocator, $source, $child);
                continue;
            }

            $items[(string) $child->getNamespacedName()] = new ReflectionClass($serviceLocator, $source, $child);
        }

        return new static($serviceLocator, $items);
    }

    public function concrete()
    {
        return new self($this->serviceLocator, array_filter($this->items, function ($item) {
            return $item->isConcrete();
        }));
    }
}

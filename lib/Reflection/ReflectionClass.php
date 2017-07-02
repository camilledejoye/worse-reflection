<?php

namespace DTL\WorseReflection\Reflection;

use DTL\WorseReflection\Reflector;
use PhpParser\Node\Stmt\ClassLike;
use DTL\WorseReflection\SourceContext;
use PhpParser\Node\Stmt\ClassMethod;
use DTL\WorseReflection\ClassName;
use PhpParser\Node\Stmt\Property;
use DTL\WorseReflection\Reflection\Collection\ReflectionMethodCollection;
use DTL\WorseReflection\Reflection\Collection\ReflectionConstantCollection;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use DTL\WorseReflection\Reflection\AbstractReflectionClass;
use Microsoft\PhpParser\NamespacedNameInterface;

class ReflectionClass extends AbstractReflectionClass
{
    /**
     * @var Reflector
     */
    private $reflector;

    /**
     * @var ClassLike
     */
    private $node;

    public function __construct(
        Reflector $reflector,
        ClassDeclaration $node
    )
    {
        $this->reflector = $reflector;
        $this->node = $node;
    }

    protected function node(): NamespacedNameInterface
    {
        return $this->node;
    }

    protected function baseClass()
    {
        if (!$this->node->classBaseClause) {
            return;
        }

        return $this->node->classBaseClause->baseClass;
    }

    protected function reflector(): Reflector
    {
        return $this->reflector;
    }

    public function properties(): array
    {
    }

}

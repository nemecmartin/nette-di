<?php

/**
 * Test: Nette\DI\PhpReflection::getReturnType
 * @phpversion 7
 */

namespace NS
{
	use Test\B;

	class A
	{
		function noType()
		{}

		function classType(): B
		{}

		function nativeType(): string
		{}

		function selfType(): self
		{}

		/** @return B */
		function annotationClassType()
		{}

		/** @return B|string */
		function annotationUnionType()
		{}

		/** @return String */
		function annotationNativeType()
		{}

		/** @return self */
		function annotationSelfType()
		{}
	}

	/** @return B */
	function annotationClassType()
	{}
}


namespace
{
	use Nette\DI\PhpReflection;
	use Tester\Assert;

	require __DIR__ . '/../bootstrap.php';


	Assert::null(PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'noType')));

	Assert::same('Test\B', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'classType')));

	Assert::same('string', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'nativeType')));

	Assert::same('NS\A', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'selfType')));

	Assert::same('Test\B', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'annotationClassType')));

	Assert::same('Test\B', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'annotationUnionType')));

	Assert::same('string', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'annotationNativeType')));

	Assert::same('NS\A', PhpReflection::getReturnType(new \ReflectionMethod(NS\A::class, 'annotationSelfType')));

	// class name expanding is NOT supported for global functions
	Assert::same('B', PhpReflection::getReturnType(new \ReflectionFunction('NS\annotationClassType')));
}

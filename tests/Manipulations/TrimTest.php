<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\AbstractManipulation;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;

/**
 * @internal
 */
#[CoversClass(Trim::class)]
#[UsesClass(AbstractManipulation::class)]
final class TrimTest extends AbstractTestCase
{
    #[DataProvider('provideValidConstructorArguments')]
    public function testConstructorWithValidArguments(string|null $colorSource, int|null $colorTolerance, string $expectedResult): void
    {
        $trim = new Trim($colorSource, $colorTolerance); // @phpstan-ignore argument.type, argument.type

        self::assertSame($expectedResult, (string) $trim);
    }

    /**
     * @return non-empty-list<array{non-empty-string|null, int|null, non-empty-string}>
     */
    public static function provideValidConstructorArguments(): array
    {
        return [
            [Trim::TOP_LEFT, Trim::COLOR_TOLERANCE_MIN, 'trim:top-left:0'],
            [Trim::TOP_LEFT, Trim::COLOR_TOLERANCE_MAX, 'trim:top-left:442'],
            [Trim::BOTTOM_RIGHT, Trim::COLOR_TOLERANCE_MIN + 1, 'trim:bottom-right:1'],
            [Trim::BOTTOM_RIGHT, Trim::COLOR_TOLERANCE_MAX - 1, 'trim:bottom-right:441'],
            [null, null, 'trim'],
            [null, 200, 'trim:200'],
            [Trim::BOTTOM_RIGHT, null, 'trim:bottom-right'],
        ];
    }

    public function testConstructorWithInvalidColorSource(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Trim: Incorrect color source value provided. Given:');

        new Trim('invalid-color-source', 100); // @phpstan-ignore argument.type
    }

    #[DataProvider('provideInvalidColorTolerance')]
    public function testConstructorWithInvalidColorTolerance(int $invalidColorTolerance): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Trim: Color tolerance value must be between');

        new Trim(Trim::TOP_LEFT, $invalidColorTolerance); // @phpstan-ignore argument.type
    }

    /**
     * @return non-empty-list<array{int}>
     */
    public static function provideInvalidColorTolerance(): array
    {
        return [
            [Trim::COLOR_TOLERANCE_MIN - 1],
            [Trim::COLOR_TOLERANCE_MAX + 1],
        ];
    }

    public function testConstructorWithAlreadySetColorTolerance(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Trim: Color tolerance has already been set');

        $trim = new Trim(Trim::TOP_LEFT, 100);
        $trim->colorTolerance(200);
    }

    public function testConstructorWithAlreadySetColorSource(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Trim: Color source has already been set');

        $trim = new Trim(Trim::TOP_LEFT, 100);
        $trim->bottomRight();
    }

    public function testValidColorToleranceMethod(): void
    {
        $colorTolerance = Trim::COLOR_TOLERANCE_MIN + 1;

        $trim = new Trim();
        $trim->colorTolerance($colorTolerance);

        self::assertSame("trim:{$colorTolerance}", (string) $trim);
    }

    public function testTopLeftMethod(): void
    {
        $trim = new Trim();
        $trim->topLeft();

        self::assertSame('trim:top-left', (string) $trim);
    }

    public function testBottomRightMethod(): void
    {
        $trim = new Trim();
        $trim->bottomRight();

        self::assertSame('trim:bottom-right', (string) $trim);
    }

    public function testNewInstanceCreation(): void
    {
        self::assertInstanceOf(Trim::class, Trim::new());
    }

    public function testIfStringable(): void
    {
        self::assertInstanceOf(\Stringable::class, new Trim()); // @phpstan-ignore staticMethod.alreadyNarrowedType
    }
}

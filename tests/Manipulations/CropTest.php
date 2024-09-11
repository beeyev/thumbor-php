<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\AbstractManipulation;
use Beeyev\Thumbor\Manipulations\Crop;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;

/**
 * @internal
 */
#[CoversClass(Crop::class)]
#[UsesClass(AbstractManipulation::class)]
final class CropTest extends AbstractTestCase
{
    #[DataProvider('provideValidConstructorArguments')]
    public function testConstructorWithValidArguments(
        int|null $topLeftX,
        int|null $topLeftY,
        int|null $bottomRightX,
        int|null $bottomRightY,
        string $expectedResult,
    ): void {
        $crop = new Crop($topLeftX, $topLeftY, $bottomRightX, $bottomRightY);

        self::assertSame($expectedResult, (string) $crop);
    }

    public static function provideValidConstructorArguments(): array
    {
        return [
            [11, 12, 22, 23, '11x12:22x23'],
            [0, 0, 0, 0, '0x0:0x0'],
            [null, null, 1, 1, 'x:1x1'],
            [1, 1, null, null, '1x1:x'],
        ];
    }

    #[DataProvider('provideInvalidNegativeArguments')]
    public function testThrowsExceptionIfNegativeValuesProvided(
        int $topLeftX,
        int $topLeftY,
        int $bottomRightX,
        int $bottomRightY,
        string $expectedExceptionMessage,
    ): void {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        new Crop($topLeftX, $topLeftY, $bottomRightX, $bottomRightY);
    }

    public static function provideInvalidNegativeArguments(): array
    {
        return [
            [-1, 12, 22, 23, 'Crop: Top-left X,Y coordinates must be non-negative integers, Given values'],
            [11, -1, 22, 23, 'Crop: Top-left X,Y coordinates must be non-negative integers, Given values'],
            [11, 12, -1, 23, 'Crop: Bottom-right X,Y coordinates must be non-negative integers, Given values:'],
            [11, 12, 22, -1, 'Crop: Bottom-right X,Y coordinates must be non-negative integers, Given values:'],
            [-1, -1, -1, -1, 'Crop: Top-left X,Y coordinates must be non-negative integers, Given values'],
        ];
    }

    public function testValidTopLeftMethod(): void
    {
        $crop = new Crop();
        $crop->topLeft(10, 20);

        self::assertSame('10x20:x', (string) $crop);
    }

    public function testValidBottomRightMethod(): void
    {
        $crop = new Crop();
        $crop->bottomRight(10, 20);

        self::assertSame('x:10x20', (string) $crop);
    }

//    public function testThrowsExceptionIfTopLeftXAlreadySet(): void
//    {
//        $crop = new Crop(10);
//
//        $this->expectException(ThumborInvalidArgumentException::class);
//        $this->expectExceptionMessage('Crop: Top-left X coordinate has already been set. Current value:');
//
//        $crop->topLeft(20, 20);
//    }
//
//    public function testThrowsExceptionIfTopLeftYAlreadySet(): void
//    {
//        $crop = new Crop();
//        $crop->topLeft(10, 20);
//
//        $this->expectException(ThumborInvalidArgumentException::class);
//        $this->expectExceptionMessage('Crop: Top-left Y coordinate has already been set. Current value:');
//
//        $crop->topLeft(10, 30);
//    }

    public function testGetStringThrowsExceptionIfNotInitialized(): void
    {
        $crop = new Crop();

        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Top-left and bottom-right coordinates must be set before calling `__toString` method.');

        (string) $crop;
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

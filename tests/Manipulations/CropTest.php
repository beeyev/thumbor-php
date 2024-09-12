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
    public function testConstructorWithValidArguments(): void
    {
        $crop = new Crop(11, 12, 22, 23);

        self::assertSame('11x12:22x23', (string) $crop);
    }

    public function testInstanceCreationWithTopLeftXAndY(): void
    {
        $this->expectNotToPerformAssertions();
        new Crop(11, 12);
    }

    public function testInstanceCreationWithBottomRightXAndY(): void
    {
        $this->expectNotToPerformAssertions();
        new Crop(null, null, 22, 23);
    }

    public function testConstructorThrowsExceptionIfTopLeftXAndYNotSetTogether(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Both top-left X and Y coordinates must be set together.');

        new Crop(11);
    }

    public function testConstructorThrowsExceptionIfBottomRightXAndYNotSetTogether(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Both bottom-right X and Y coordinates must be set together.');

        new Crop(null, null, 22);
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

        new Crop($topLeftX, $topLeftY, $bottomRightX, $bottomRightY); // @phpstan-ignore argument.type, argument.type, argument.type,  argument.type
    }

    /**
     * @return array<array{int, int, int, int, string}>
     */
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
        $crop = new Crop(bottomRightX: 22, bottomRightY: 23);
        $crop->topLeft(10, 20);

        self::assertSame('10x20:22x23', (string) $crop);
    }

    public function testValidBottomRightMethod(): void
    {
        $crop = new Crop(topLeftX: 10, topLeftY: 20);
        $crop->bottomRight(22, 23);

        self::assertSame('10x20:22x23', (string) $crop);
    }

    public function testTopLeftThrowsExceptionIfAlreadySet(): void
    {
        $crop = new Crop(10, 20, 22, 23);

        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Top-left X,Y coordinates have already been set. Current values:');

        $crop->topLeft(10, 20);
    }

    public function testBottomRightThrowsExceptionIfAlreadySet(): void
    {
        $crop = new Crop(10, 20, 22, 23);

        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Bottom-right X,Y coordinates have already been set. Current values:');

        $crop->bottomRight(22, 23);
    }

    public function testStaticInstanceCreation(): void
    {
        $crop = Crop::new()->topLeft(10, 20)->bottomRight(22, 23); // @phpstan-ignore method.notFound

        self::assertSame('10x20:22x23', (string) $crop);
    }

    public function testToStringThrowsExceptionIfNotInitialized(): void
    {
        $crop = new Crop();

        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Top-left and bottom-right coordinates must be set before calling `__toString` method.');

        (string) $crop;
    }

    public function testToStringThrowsExceptionIfTopLeftNotInitialized(): void
    {
        $crop = new Crop(bottomRightX: 22, bottomRightY: 23);

        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Top-left coordinates must be set before calling `__toString` method.');

        (string) $crop;
    }

    public function testToStringThrowsExceptionIfBottomRightNotInitialized(): void
    {
        $crop = new Crop(topLeftX: 10, topLeftY: 20);

        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('Crop: Bottom-right coordinates must be set before calling `__toString` method.');

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

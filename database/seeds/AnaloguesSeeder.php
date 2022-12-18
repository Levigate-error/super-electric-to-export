<?php

use Illuminate\Database\Seeder;
use Database\Seeds\Helpers\AnalogResources as ResourcesHelper;
use Illuminate\Support\Arr;
use App\Models\Analogue;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AnaloguesSeeder extends Seeder
{
    public const LANG = 'ru';
    public const LEGRAND_VENDOR = 'Legrand';
    public const EMPTY_VENDOR_CODE_SIGNS = ['=#Н/Д', '0'];

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function run(): void
    {
        DB::table('analogues')->truncate();

        $resourcesHelper = new ResourcesHelper();
        $analogFiles = $resourcesHelper->getAnaloguesFromFiles(self::LANG);

        $this->saveAnalogs($analogFiles);
    }

    /**
     * @param array $analogFiles
     */
    protected function saveAnalogs(array $analogFiles): void
    {
        $analogs = [];
        /**
         * По файлам
         */
        foreach ($analogFiles as $analogFile) {
            /**
             * По вкладкам в файле
             */
            foreach ($analogFile as $analogCategory => $analogSheet) {
                /**
                 * Если нет списка с товарами легранда, то пропускаем
                 */
                if (!isset($analogSheet[self::LEGRAND_VENDOR])) {
                    continue;
                }

                /**
                 * Собираем легранловские товары
                 */
                $legrandItems = $analogSheet[self::LEGRAND_VENDOR]['items'];
                $legrandVendorCodes = Arr::pluck($legrandItems, 'vendor_code');
                $legrandProducts = Product::query()->whereIn('vendor_code', $legrandVendorCodes)->get()->keyBy('vendor_code');

                foreach ($analogSheet as $vendor => $vendorAnalogs) {
                    if ($vendor === self::LEGRAND_VENDOR) {
                        continue;
                    }

                    $analogCounter = 0;
                    foreach ($vendorAnalogs['items'] as $itemNumber => $itemValue) {
                        /**
                         * Если нет легранд аналога, то пропускаем
                         */
                        if (!isset($legrandItems[$itemNumber])) {
                            continue;
                        }

                        /**
                         * Если нет товара с таким артикулом, то пропускаем
                         */
                        $legrandVendorCode = $legrandItems[$itemNumber]['vendor_code'];
                        if (!$legrandProducts->has($legrandVendorCode)) {
                            continue;
                        }

                        if (!$this->validateAnalog($itemValue)) {
                            continue;
                        }

                        $currentAnalog = Analogue::query()->where('vendor_code', $itemValue['vendor_code'])->first();
                        if (!$currentAnalog) {
                            $currentAnalog = new Analogue([
                                'vendor_code' => $itemValue['vendor_code'],
                                'description' => json_encode([self::LANG => $itemValue['description']]),
                                'vendor' => $itemValue['vendor'],
                            ]);
                            $currentAnalog->trySaveModel();
                        }

                        $analogs[$legrandVendorCode][] = $currentAnalog->id;
                        $analogCounter++;
                    }

                    $this->command->info("Category: $analogCategory. Vendor: $vendor. $analogCounter analogs was parsed.");
                }
            }
        }

        /**
         * Заносим связь аналоги и товара в БД
         */
        foreach ($analogs as $productVendorCode => $productAnalogs) {
            $product = Product::query()->where('vendor_code', $productVendorCode)->first();
            $product->analogues()->sync($productAnalogs);
        }
    }

    /**
     * @param array $itemValue
     * @return bool
     */
    protected function validateAnalog(array $itemValue): bool
    {
        $emptyVendorCodeExists = Arr::exists(self::EMPTY_VENDOR_CODE_SIGNS, $itemValue['vendor_code']);

        return !$emptyVendorCodeExists && !empty($itemValue['vendor_code']);
    }
}

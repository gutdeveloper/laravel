<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger para INSERT
        DB::unprepared('
            CREATE TRIGGER update_product_quantity_after_variant_insert
            AFTER INSERT ON product_variants
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET quantity = (SELECT COALESCE(SUM(quantity), 0) FROM product_variants WHERE product_id = NEW.product_id)
                WHERE id = NEW.product_id;
            END;
        ');

        // Trigger para UPDATE
        DB::unprepared('
            CREATE TRIGGER update_product_quantity_after_variant_update
            AFTER UPDATE ON product_variants
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET quantity = (SELECT COALESCE(SUM(quantity), 0) FROM product_variants WHERE product_id = NEW.product_id)
                WHERE id = NEW.product_id;
            END;
        ');

        // Trigger para DELETE
        DB::unprepared('
            CREATE TRIGGER update_product_quantity_after_variant_delete
            AFTER DELETE ON product_variants
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET quantity = (SELECT COALESCE(SUM(quantity), 0) FROM product_variants WHERE product_id = OLD.product_id)
                WHERE id = OLD.product_id;
            END;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_quantity_after_variant_insert;');
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_quantity_after_variant_update;');
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_quantity_after_variant_delete;');
    }
};

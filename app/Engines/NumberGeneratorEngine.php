<?php

namespace App\Engines;

use App\Models\NumberSequence;
use Illuminate\Support\Facades\DB;

/**
 * Part-9.3 Reusable Engine: generates EVERY public identifier in the system
 * (Student ID, Teacher ID, Admission No, Receipt No, Certificate No, Marksheet No...).
 * No module should implement its own numbering — always call this engine.
 *
 * Format produced: {PREFIX}-{YEAR}-{padded sequence}, e.g. STU-2026-0001
 * Institutions can override prefix/padding/year usage per sequence_key via the
 * number_sequences table (Settings module, Part-1/4 "Configuration Driven, No Hard Coding").
 */
class NumberGeneratorEngine
{
    public function next(int $institutionId, string $sequenceKey, string $defaultPrefix, bool $useYear = true): string
    {
        $year = $useYear ? (int) now()->format('Y') : null;

        return DB::transaction(function () use ($institutionId, $sequenceKey, $defaultPrefix, $year) {
            $sequence = NumberSequence::where('institution_id', $institutionId)
                ->where('sequence_key', $sequenceKey)
                ->where('year_component', $year)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                $sequence = NumberSequence::create([
                    'institution_id' => $institutionId,
                    'sequence_key' => $sequenceKey,
                    'prefix' => $defaultPrefix,
                    'year_component' => $year,
                    'padding' => 4,
                    'last_value' => 0,
                ]);
            }

            $sequence->increment('last_value');
            $sequence->refresh();

            $padded = str_pad((string) $sequence->last_value, $sequence->padding, '0', STR_PAD_LEFT);

            $parts = array_filter([$sequence->prefix, $year, $padded]);

            return implode('-', $parts);
        });
    }
}

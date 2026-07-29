<?php

namespace App\Engines;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Part-6/7/9 Reusable Engine: "One document engine should generate every official
 * document" — Student ID Card, Admit Card, Marksheet, TC, Certificates, etc.
 * Extend generate() with more $documentType cases as modules are added; the calling
 * code (a controller/Livewire action) always looks the same:
 *   app(DocumentEngine::class)->generate('student_id_card', $student);
 */
class DocumentEngine
{
    public function generate(string $documentType, mixed $entity): \Barryvdh\DomPDF\PDF
    {
        return match ($documentType) {
            'student_id_card' => $this->studentIdCard($entity),
            default => throw new \InvalidArgumentException("Unknown document type [{$documentType}]"),
        };
    }

    protected function studentIdCard(Student $student): \Barryvdh\DomPDF\PDF
    {
        $qr = app(QrEngine::class)->svg($student->qr_token);

        return Pdf::loadView('documents.student-id-card', [
            'student' => $student,
            'institution' => $student->institution,
            'qrSvg' => $qr,
        ])->setPaper([0, 0, 242, 153]); // ID-card sized page
    }
}

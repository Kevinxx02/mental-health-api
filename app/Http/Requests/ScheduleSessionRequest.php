<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ScheduleSessionRequest extends FormRequest {
    public function authorize() : bool {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules() : array {
        return [
            'patient_id' => [
                'required',
                'uuid',
            ],
            'therapist_id' => [
                'required',
                'uuid',
            ],
            'session_date' => [
                'required',
                'date',
            ],
        ];
    }
}

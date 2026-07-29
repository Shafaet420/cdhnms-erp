<?php

namespace App\Engines;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

/**
 * Part-3/7/9 Reusable Engine: Draft -> Submitted -> Under Review -> Verified ->
 * Approved -> Completed -> Archived -> Need Correction.
 *
 * Any model with a `workflow_state` column and a matching `*_workflow_logs` relation
 * (see AdmissionApplication + AdmissionWorkflowLog for the reference implementation)
 * can reuse this engine instead of writing one-off transition logic per module —
 * satisfying Part-1's "no duplicate business logic" rule.
 */
class WorkflowEngine
{
    /** @var array<string, array<string>> allowed_from => [allowed_to...] */
    protected array $allowedTransitions = [
        'draft' => ['submitted'],
        'submitted' => ['under_review', 'need_correction'],
        'under_review' => ['verified', 'need_correction', 'rejected'],
        'verified' => ['approved', 'need_correction', 'rejected'],
        'approved' => ['completed'],
        'need_correction' => ['submitted'],
        'completed' => ['archived'],
        'rejected' => ['archived'],
    ];

    public function canTransition(string $from, string $to): bool
    {
        return in_array($to, $this->allowedTransitions[$from] ?? [], true);
    }

    /**
     * @param  Model  $entity  Must expose `workflow_state`, a `workflowLogs()` relation,
     *                         and the log model must accept from_state/to_state/actor_user_id/remarks.
     */
    public function transition(Model $entity, string $toState, ?string $remarks = null): Model
    {
        $fromState = $entity->workflow_state;

        if (! $this->canTransition($fromState, $toState)) {
            throw new RuntimeException("Cannot transition from [{$fromState}] to [{$toState}].");
        }

        $entity->workflow_state = $toState;
        $entity->save();

        $entity->workflowLogs()->create([
            'from_state' => $fromState,
            'to_state' => $toState,
            'actor_user_id' => Auth::id(),
            'remarks' => $remarks,
            'created_at' => now(),
        ]);

        return $entity;
    }
}

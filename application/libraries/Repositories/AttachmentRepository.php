<?php

/**
 * Class that does the interaction with the attachments entities
 * Class AttachmentRepository
 */
class AttachmentRepository extends PmsRepository
{

    /**
     * Links the attachments marked for including to the given proposal id
     * @param $companyId
     * @param $proposalId
     */
    public function linkCheckedAttachments($companyId, $proposalId)
    {
        $this->db->query("INSERT INTO proposals_attatchments (attatchment, proposal) (SELECT attatchmentId AS attatchment, {$proposalId} AS proposal FROM attatchments WHERE company = {$companyId} AND include = 1)");
    }
}
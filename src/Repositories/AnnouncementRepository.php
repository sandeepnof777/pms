<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use \models\Companies;
use \Carbon\Carbon;
use \models\Accounts;

class AnnouncementRepository extends RepositoryAbstract
{
    use DBTrait;


    /**
     * @return \models\Announcement
     */
    public function create()
    {
        $announcement = new \models\Announcement();
        $announcement->setAdmin(0);
        $announcement->setSticky(0);
        $announcement->setOrd(999);
        // Default released to now
        $announcement->setReleased(Carbon::now());
        // Default expires to 2 weeks from now
        $announcement->setExpires(Carbon::now()->addWeeks(2));

        return $announcement;
    }

    public function getAllActiveAnnouncements()
    {
        $dql = "SELECT a
        FROM \models\Announcement a
        WHERE a.expires > :now
        ORDER BY a.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':now', Carbon::now()->toDateTimeString());

        return $query->getResult();
    }

    public function getAllExpiredAnnouncements()
    {
        $dql = "SELECT a
        FROM \models\Announcement a
        WHERE a.expires < :now
        ORDER BY a.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':now', Carbon::now()->toDateTimeString());

        return $query->getResult();
    }

    public function getUserAnnouncements(Accounts $account, $objectArray = true)
    {
        // Set admin flag
        $admin = false;
        if ($account->isAdministrator()) {
            $admin = true;
        }

        // Build base query
        $sql = "SELECT a.id
        FROM announcements a
        LEFT JOIN announcements_hidden ah ON a.id = ah.announcement_id AND ah.account_id = :accountId
        WHERE ah.id IS NULL
        AND a.released <= :released
        AND a.expires >= :expires";

        // Apply admin parameter if necessary
        if (!$admin) {
            $sql .= " AND a.admin = 0";
        }

        // Order
        $sql .= " ORDER BY a.ord ASC";

        // Build query
        $query = $this->em->getConnection()->prepare($sql);
        // Set Params
        $query->bindValue('released', Carbon::now()->toDateTimeString());
        $query->bindValue('expires', Carbon::now()->toDateTimeString());
        $query->bindValue('accountId', $account->getAccountId());
        $results = $query->execute();

        $announcementsResult = $results->fetchAllAssociative();

        $announcements = [];

        foreach ($announcementsResult as $result) {
            $announcement = $this->em->find('models\Announcement', $result['id']);
            $announcements[] = $announcement;
        }

        if (!$objectArray) {
            return $announcements;
        }

        $out = [];
        foreach ($announcements as $announcement) {
            /* @var $announcement \models\Announcement */
            $obj = new \stdClass();
            $obj->id = $announcement->getId();
            $obj->title = $announcement->getTitle();
            $obj->content = $announcement->getText();
            $obj->admin = intval($announcement->getAdmin());
            $obj->sticky = intval($announcement->getSticky());
            $out[] = $obj;
        }
        return $out;
    }

}
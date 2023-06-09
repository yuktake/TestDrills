<?php
namespace App\OnlineSupermarket\Domain\Customer;


class Customer {

    private ?int $id;

    private string $name;

    private ?SpecialMembershipInfo $specialMembershipInfo;

    private ?CardMembershipInfo $cardMembershipInfo;

    private ?MobileMembershipInfo $mobileMembershipInfo;

    public function __construct(
        ?int $id,
        string $name,
        ?SpecialMembershipInfo $specialMembershipInfo,
        ?CardMembershipInfo $cardMembershipInfo,
        ?MobileMembershipInfo $mobileMembershipInfo,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->specialMembershipInfo = $specialMembershipInfo;
        $this->cardMembershipInfo = $cardMembershipInfo;
        $this->mobileMembershipInfo = $mobileMembershipInfo;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getName():string {
        return $this->name;
    }

    public function isSpecialMembership():bool {
        return !is_null($this->specialMembershipInfo);
    }

    public function isCardMembership():bool {
        return !is_null($this->cardMembershipInfo);
    }

    public function isMobileMembership():bool {
        return !is_null($this->mobileMembershipInfo);
    }

    public function getTimesForPoint(\DateTimeImmutable $dateTime):int {
        $times = 0;

        if($this->isSpecialMembership()) {
            $times+=3;
        }

        if($this->isCardMembership()) {
            $times+=2;
        }

        if($this->isMobileMembership()) {
            $times+=5;
        }

        $date = intval($dateTime->format('j'));
        if($date == 15) {
            $times+=3;
        }

        // どれにも該当しない場合は通常の1倍を返す
        if($times == 0) {
            return 1;
        }

        return $times;
    }
}
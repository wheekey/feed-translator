<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 16.03.18
 * Time: 17:32
 */

namespace kymbrik\src\extractor;

//TODO удалить
class BannerExtractor implements DataExtractor
{
    public function __construct()
    {
    }

    public function extract()
    {
        $newslettersRepository = new \kymbrik\src\repository\interspire\NewslettersRepository();
        $newsletterStatsRepository = new \kymbrik\src\repository\interspire\NewsletterStatsRepository();
        $localBannerRepository = new \kymbrik\src\repository\local\FeedsRepository();

        $maxNewsletterId = $localBannerRepository->findMaxId();

        $newsletters = isset($maxNewsletterId) ? $newslettersRepository->findAll($maxNewsletterId) : $newslettersRepository->findAll(0);

        foreach ($newsletters as $newsletter) {
            $banner = $this->extractBanner($newsletter->getHtmlBody());
            if (strlen($banner) < 50) {
                $newsletterStats = $newsletterStatsRepository->findByNewsletterId($newsletter->getNewsletterId());
                if ($newsletterStats) {
                    $localBannerRepository->save(new \kymbrik\src\model\local\Banner([
                        "newsletterId" => $newsletter->getNewsletterId(),
                        "bannerCode" => $banner,
                        "startTime" => $newsletterStats->getStartTime()
                    ]));
                }
            }
        }
    }

    private function extractBanner(string $htmlCode)
    {
        return preg_replace("/.*banner_id=([0-9a-zA-Z_]*?)\&.*/xuis", "$1", $htmlCode);
    }
}
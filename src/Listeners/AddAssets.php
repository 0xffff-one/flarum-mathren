<?php
namespace TheTurk\MathRen\Listeners;

use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;

class AddAssets
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var Application
    */
    protected $app;

    /**
     * @var string $settingsPrefix
     */
    public $settingsPrefix = 'the-turk-mathren';

    /**
     * LoadSettingsFromDatabase constructor
     *
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param Document $document
     */
    public function __invoke(Document $document)
    {
        $this->assets($document);
    }

    private function assets(Document &$document)
    {
        // include KaTeX stylesheet
        $document->head[] = '<link rel="preload" href="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/katex.min.css" as="style" integrity="sha256-V8SV2MO1FUb63Bwht5Wx9x6PVHNa02gv8BgH/uH3ung=" onload="this.onload=null;this.rel=\'stylesheet\'" crossorigin="anonymous">';
        $document->head[] = '<script defer src="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/katex.min.js" integrity="sha256-F/Xda58SPdcUCr+xhSGz9MA2zQBPb0ASEYKohl8UCHc=" crossorigin="anonymous"></script>';
        $document->head[] = '<script defer src="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/contrib/auto-render.min.js" integrity="sha256-90d2pnfw0r4K8CZAWPko4rpFXQsZvJhTBGYNkipDprI=" crossorigin="anonymous"></script>';

        // stylize <span /> wrapper
        $spanStyle = $this->settings->get($this->settingsPrefix.'.wrapperStyle', '');
        // remove new lines to minify it
        $spanStyle = trim(preg_replace('/\s+/', '', $spanStyle));
        if (!empty($spanStyle)) {
            $document->head[] = '<style type="text/css">'.$spanStyle.'</style>';
        }
    }
}

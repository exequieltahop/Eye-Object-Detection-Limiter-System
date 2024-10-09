<?php 
    namespace Utilities\Tools;

    require __DIR__.'/../../config/app.php';

    use Configuration\AppConfiguration;
    use DateTime;
    use DateTimeZone;

    class DateTool{
        public static function Now() : DateTime {
            try {
                return new DateTime('now', new DateTimeZone(AppConfiguration::$TimeZone));
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
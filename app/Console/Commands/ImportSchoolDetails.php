<?php

namespace App\Console\Commands;

use DB;
use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use League\Csv\Reader as Csv;

class ImportSchoolDetails extends Command
{
    /**
     * The host to download datasets from.
     *
     * @var string
     */
    private const HOST = "https://data-nces.opendata.arcgis.com/datasets/";

    /**
     * The dataset to parse school information from.
     *
     * @var string
     */
    private const DATASET = "7e9f773ef00d4bd9b27d3fc1dc4727b0_0";

    /**
     * The fields to parse from the dataset rows.
     *
     * @var string
     */
    private const FIELDS = [
        /*
         *
         * Summary:
         */
        // 'X',

        /*
         *
         * Summary:
         */
        // 'Y',

        /*
         *
         * Summary:
         */
        // 'OBJECTID',

        /*
         * School identification number
         *
         * Summary: These IDs are 12 digit numbers assigned by the National
         *          Center for Education Statistics.
         *
         *          The first 7 digits of the NCESSCH are the LEAID for the
         *          associated school district, and the following 5 digits
         *          uniquely identify the school within the district.
         */
        'NCESSCH',

        /*
         * School name
         *
         * Summary: This data is represented as reported in the Common Core of
         *          Data, and as such does not necessarily fall into any
         *          particular specified domain.
         */
        'NAME',

        /*
         * School reported operating state
         */
        // 'OPSTFIPS',

        /*
         * Reported location address
         *
         * Summary: This data is represented as reported in the Common Core of
         *          Data, and as such does not necessarily fall into any
         *          particular specified domain.
         */
        'STREET',

        /*
         * Reported location city
         *
         * Summary: This data is represented as reported in the Common Core of
         *          Data, and as such does not necessarily fall into any
         *          particular specified domain.
         */
        'CITY',

        /*
         * Reported location state
         *
         * Summary: This data is represented as reported in the Common Core of
         *          Data, and as such does not necessarily fall into any
         *          particular specified domain.
         */
        'STATE',

        /*
         * Reported location ZIP code
         *
         * Summary: This data is represented as reported in the Common Core of
         *          Data, and as such does not necessarily fall into any
         *          particular specified domain.
         */
        'ZIP',

        /*
         * Reported location FIPS code
         */
        // 'STFIP',

        /*
         * Country FIPS
         */
        // 'CNTY',

        /*
         * Current name and the translated legal/statistical area description
         * for county
         *
         * Summary: The NMCNTY attribute is a concatenation of the county name
         *          followed by the translated legal/statistical area
         *          description
         */
        // 'NMCNTY',

        /*
         * NCES Locale Code
         *
         * Summary: * 11 - City, Large
         *          * 12 - City, Midsize
         *          * 13 - City, Small
         *          * 21 - Suburban, Large
         *          * 22 - Suburban, Midsize
         *          * 23 - Suburban, Small
         *          * 31 - Town, Fringe
         *          * 32 - Town, Distant
         *          * 33 - Town, Remote
         *          * 41 - Rural, Fringe
         *          * 42 - Rural, Distant
         *          * 43 - Rural, Remote
         */
        'LOCALE',

        /*
         * Latitude of school location
         *
         * Summary: -90 to 90
         */
        'LAT',

        /*
         * Longitude of school location
         *
         * Summary: -180 to 180
         */
        'LON',

        /*
         * Current metropolitan/micropolitan statistical area code
         *
         * Summary: 10000 to 49999
         *
         *          A value of N indicates that the school is not in a CBSA
         */
        // 'CBSA',

        /*
         * Current metropolitan/micropolitan statistical area name
         *
         * Summary: A value of N indicates that the school is not in a CBSA
         */
        // 'NMCBSA',

        /*
         * Current metropolitan/micropolitan status indicator
         *
         * Summary: * 1 - Metropolitan
         *          * 2 - Micropolitan
         *          * 0 - Not in a Metropolitan or Micropolitan Statistical
         *                Area
         */
        // 'CBSATYPE',

        /*
         * Current combined statistical area code
         *
         * Summary: A value of N indicates that the school is not located in a
         *          CSA
         */
        // 'CSA',

        /*
         * Current combined statistical area name
         *
         * Summary: CSA names are defined by the Office of Management and
         *          Budget and updated periodically
         *
         *          A value of N indicates that the school is not located in a
         *          CSA
         */
        // 'NMCSA',

        /*
         * Current New England City and Town Area code
         *
         * Summary: 70000 - 79999
         *
         *          A value of N indicates that the school is not located in a
         *          NECTA
         */
        // 'NECTA',

        /*
         * Current New England City and Town Area code
         *
         * Summary: NECTA names are defined by the Office of Management and
         *          Budget and updated periodically
         *
         *          A value of N indicates that the school is not located in a
         *          NECTA
         */
        // 'NMNECTA',

        /*
         * 116th Congressional District identifier, a concatenation of state
         * FIPS code and the 116th Congressional District FIPS code
         *
         * Summary: The CD attribute is a concatenation of the state FIPS code
         *          followed by the CD FIPS code. No spaces are allowed between
         *          the two codes. The State FIPS code is taken from "National
         *          Standard Codes (ANSI INCITS 38-2009), Federal Information
         *          Processing Series (FIPS) - States." The CD FIPS code is
         *          taken from "National Standard Codes (ANSI INCITS 455-2009),
         *          Federal Information Processing Series (FIPS) -
         *          Congressional Districts."
         *
         *          A value of N indicates that Congressional District is Not
         *          Applicable for this school
         */
        // 'CD',

        /*
         * State legislative district (lower chamber) identifier, a
         * concatenation of state FIPS code and the SLDL code.
         *
         * Summary: The SLDL attribute is a concatenation of the state FIPS
         *          code followed by the SLDL code. The state FIPS code is
         *          taken from "National Standard Codes (ANSI INCITS 38-2009),
         *          Federal Information Processing Series (FIPS) - States." The
         *          SLDL code consists of any ASCII alphabetic or numeric
         *          character combination plus hyphens. A code of ZZZ
         *          represents a state legislative district (lower chamber)
         *          that has not been defined.
         *
         *          A value of N indicates that SLDL is Not Applicable for this
         *          school
         */
        // 'SLDL',

        /*
         * State legislative district (upper chamber) identifier, a
         * concatenation of state FIPS code and the SLDU code.
         *
         * Summary: The SLDU attribute is a concatenation of the state FIPS
         *          code followed by the SLDU code. The state FIPS code is
         *          taken from "National Standard Codes (ANSI INCITS 38-2009),
         *          Federal Information Processing Series (FIPS) - States." The
         *          SLDU code consists of any ASCII alphabetic or numeric
         *          character combination plus hyphens. A code of ZZZ
         *          represents a state legislative district (upper chamber)
         *          that has not been defined.
         *
         *          A value of N indicates that SLDU is Not Applicable for this
         *          school
         */
        // 'SLDU',

        /*
         * School academic year
         */
        // 'SCHOOLYEAR',

        /*
         * School district identification number
         *
         * Summary: These IDs are 7 digit numbers assigned by the National
         *          Center for Education Statistics
         */
        // 'LEAID',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:schools {--truncate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import federal school locations from Data.gov';

    /**
     * The url to parse school information from.
     *
     * @var string
     */
    protected $url;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url  = Str::finish(self::HOST, '/');
        $this->url .= Str::finish(self::DATASET, '.csv');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('truncate')) {
            DB::table('schools')->truncate();
        }

        $this->line("Fetching data from {$this->url}...");

        $data = $this->fetch($this->url);

        if (! $data) {
            $this->warning('No data records found.');
            return 1;
        }

        $this->info('Finished fetching data, attempting to parse records...');

        $csv = $this->parseCsvString($data);
        $records = $this->parseCsvRecords($csv, self::FIELDS);

        $this->info('Parsed data records, attempting to import...');

        $count =$this->import($records);

        $this->info("Imported institution data, {$count} new records!");
    }

    public function fetch(string $url)
    {
        $res = Http::get($url);

        return $res->ok() ? $res->body() : null;
    }

    public function import(array $records)
    {
        $bar = $this->output->createProgressBar(count($records));

        $records = collect($records)
            ->chunk(100)
            ->each(function ($chunk) use (&$bar) {
                School::insert($chunk->toArray());

                // hardcode 100 to avoid n recounts
                $bar->advance(100);
            });

        School::query()->update([
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $numInserted = $bar->getProgress();
        $bar->finish();
        $this->newLine();

        return $numInserted;
    }

    public function parseCsvString(string $data)
    {
        $csv = Csv::createFromString($data);
        $csv->setHeaderOffset(0);

        return $csv;
    }

    public function parseCsvRecords(Csv $csv, array $fields)
    {
        $records = $csv->skipEmptyRecords()->getRecords();
        $records = iterator_to_array($records);

        foreach ($records as $idx => $record) {
            $record = array_intersect_key($record, array_flip($fields));

            $records[$idx] = [
                'district_id' => substr(''.$record['NCESSCH'], 0, 6),
                'school_id'   => substr(''.$record['NCESSCH'], 7, 11),
                'name'        => $record['NAME'],
                'locale'      => $record['LOCALE'],
                'street'      => $record['STREET'],
                'city'        => $record['CITY'],
                'state'       => $record['STATE'],
                'zip'         => $record['ZIP'],
                'latitude'    => number_format($record['LAT'], 6),
                'longitude'   => number_format($record['LON'], 6),
            ];
        }

        return $records;
    }
}

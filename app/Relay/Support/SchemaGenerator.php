<?php namespace BibleExperience\Relay\Support;

use BibleExperience\Relay\Schema\BibleExchangeSchema;
use BibleExperience\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GraphQL\GraphQL;

class SchemaGenerator
{
    /**
     * Generate relay schema.json file.
     *
     * @param  string $version
     * @return boolean
     */
    public function execute($version = '4.12')
    {
        $schema = BibleExchangeSchema::build();
        $query = file_get_contents(realpath(__DIR__.'/assets').'/introspection-'. $version .'.txt');
        $data = GraphQL::execute($schema, $query, null, null);
	
        if (isset($data['data']['__schema'])) {
            $schemaJSON = json_encode($data);
            $path = realpath(__DIR__.'/../../../../be-front-new/server/data').'/schema.json';
            $this->put($path, $schemaJSON);
        }

        return $data;
    }

    /**
     * Put to a file path.
     *
     * @param  string $path
     * @param  string $contents
     * @return mixed
     */
    protected function put($path, $contents)
    {
        $this->makeDirectory(dirname($path));

        return file_put_contents($path, $contents);
    }

    /**
     * Make a directory tree recursively.
     *
     * @param  string $dir
     * @return void
     */
    protected function makeDirectory($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

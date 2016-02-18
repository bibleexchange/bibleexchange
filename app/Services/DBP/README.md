## Installation

Add this file to a directory accessible by your PHP source code.

## Usage

Below are the steps neccessary to get you started with the DBT SDK.

### 1. Sign up for an API Key

Before you can start using the DBT SDK, you will need to sign up for an API Key at [https://www.digitalbibleplatform.com](https://www.digitalbibleplatform.com).  

### 2. Include the SDK file

In your page or script, include the class file.

```

require_once('Dbt.php');
	
```

### 3. Create an instance of the object

When creating the object, pass the API key.

```

$dbt = new Dbt($apiKey);

```

### 4. Retrieve volume information

For an example of the usual work flows, as well as examples of retrieving and displaying text, audio, and video, download the [sample code repository](https://bitbucket.org/hidef/dbt-sample-code).

## API Documentation

Documentation for the underlying REST API can be found in the [Digital Bible Platform Developer Documentation](http://stage.digitalbibleplatform.com/docs).

## License

dbt-sdk is available under the MIT license. See the LICENSE file for more info.

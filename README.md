File Utils
=============
[![Latest Stable Version](https://poser.pugx.org/reynholm/file-utils/v/stable.svg)](https://packagist.org/packages/reynholm/file-utils) [![Total Downloads](https://poser.pugx.org/reynholm/file-utils/downloads.svg)](https://packagist.org/packages/reynholm/file-utils) [![Latest Unstable Version](https://poser.pugx.org/reynholm/file-utils/v/unstable.svg)](https://packagist.org/packages/reynholm/file-utils) [![License](https://poser.pugx.org/reynholm/file-utils/license.svg)](https://packagist.org/packages/reynholm/file-utils)

[![Build Status](https://travis-ci.org/reynholm-industries/FileUtils.svg?branch=master)](https://travis-ci.org/reynholm-industries/FileUtils)

Multiple tools for working with files

# Abandoned!
This package is abandoned as you can see on packagist. I moved to python and I have no time for keeping this repo up to date with Laravel. Feel free to fork it and maintaining it yourself.

##Examples:

###ArrayConversor
```php5
<?php
$csvFileName = $arrayConversor->toCsv($inputArray, $destinationFile);
$xlsFileName = $arrayConversor->toXls($inputArray, $destinationFile);
```

###CsvFileConversor
```php5
<?php
$array = $this->csvConversor->toArray($csvFile, $rowsToSkip, $useFirstRowAsKeys, $delimiterChar);
```


###XlsFileConversor
```php5
<?php
$array = $this->xlsConversor->toArray($xlsFile);
```

Check the unit tests folder for more examples.

To run the tests use the command
```shell
vendor\bin\codecept run unit
```

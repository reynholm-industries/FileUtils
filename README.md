File Utils
=============
[![Build Status](https://travis-ci.org/reynholm-industries/FileUtils.svg?branch=master)](https://travis-ci.org/reynholm-industries/FileUtils)

Multiple tools for working with files

##Examples:

###ArrayConversor
```
$csvFileName = $arrayConversor->toCsv($inputArray, $destinationFile);
$xlsFileName = $arrayConversor->toXls($inputArray, $destinationFile);
```

###CsvFileConversor
```
$array = $this->csvConversor->toArray($csvFile, $rowsToSkip, $useFirstRowAsKeys, $delimiterChar);
```


###XlsFileConversor
```
$array = $this->xlsConversor->toArray($xlsFile);
```

Check the unit tests folder for more examples.

To run the tests use the
```
command vendor\bin\codecept run unit
```
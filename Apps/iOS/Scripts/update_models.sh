#!/bin/sh
MODEL_PATH="Smuoy/Smuoy.xcdatamodeld/"
OUTPUT_PATH="Smuoy/Models"

./Scripts/mogenerator --swift \
	-m "${MODEL_PATH}" \
	-H "${OUTPUT_PATH}/" \
	-M "${OUTPUT_PATH}/Generated" \
    --base-class ManagedObject

echo "Due to a bug you need to add 'import THCCoreData' to the generated swift files."

#!/bin/bash

# Need to use large file storage (https://git-lfs.com/) for files
# with size > 100mb

echo "git-add-dirs.sh"

# Define the target directory
directory="/Users/billstclair/etwof/billstclair.com"

# Check if the target is not a directory
if [ ! -d "$directory" ]; then
    echo "not a directory: $directory"
  exit 1
fi

# Loop through files in the target directory
for file in "$directory"/*; do
    if [ -d "$file" ]; then
        echo "pushing $file"
        git add "$file"
        git commit -m "$file" >/dev/null
        git push
        echo "$file pushed"
    fi
done

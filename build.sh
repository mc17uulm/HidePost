#!/bin/bash

base_dir=$PWD
build_dir="$base_dir/build"
plugin_dir="$base_dir/wordpress/wp-content/plugins/HidePost"

echo "DELETE old build files"
rm -rf "$build_dir/*"

echo "CREATE build dir"
mkdir "$build_dir/HidePost"

echo "COPY plugin dir"
cp -a "$plugin_dir/." "$build_dir/HidePost/"

project_dir="$build_dir/HidePost"

echo "REMOVE unnessecary files"
rm -rf "$project_dir/.idea/"
rm -rf "$project_dir/lang/"
rm -rf "$project_dir/dist/"

echo "CREATE zip archive"
cd "$build_dir/"
zip -r -X "HidePost.zip" "./HidePost/"

echo "REMOVE tmp files"
rm -rf "./HidePost/"

echo "FINISHED"
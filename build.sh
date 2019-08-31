#!/bin/bash

base_dir=$PWD
build_dir="./build"
svn_dir="$build_dir/svn/trunk"
plugin_dir="$base_dir/wordpress/wp-content/plugins/HidePost"

echo "DELETE old build files"
rm -rf "$build_dir/zip/HidePost.zip"
rm -rf "$build_dir/tmp/HidePost/"

echo "CREATE build dir"
project_dir="$build_dir/tmp/HidePost"
mkdir "$project_dir"

echo "COPY plugin dir"
cp -a "$plugin_dir/." "$project_dir/"

echo "REMOVE unnessecary files"
rm -rf "$project_dir/.idea/"
rm -rf "$project_dir/dist/"

echo "UPDATE svn"
rsync -a -u "$project_dir/." "$svn_dir/"

echo "CREATE zip archive"
cd "$build_dir/tmp/"
zip -r -X "./../zip/HidePost.zip" "./HidePost/"

echo "REMOVE tmp files"
rm -rf "./HidePost/"

echo "FINISHED"
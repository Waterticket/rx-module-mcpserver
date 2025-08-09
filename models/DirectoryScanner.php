<?php

namespace Rhymix\Modules\Mcpserver\Models;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

class DirectoryScanner
{
    /**
     * 주어진 baseDir + pattern에서 일치하는 디렉토리를 찾고,
     * 그 하위 모든 디렉토리를 반환
     *
     * @param string $baseDir  기준 디렉토리 (예: __DIR__)
     * @param string $pattern  glob 패턴 (예: "example/*")
     * @return array           baseDir 기준의 상대 경로 배열
     */
    public static function scan(string $baseDir, string $pattern): array
    {
        $baseDir = realpath(rtrim($baseDir, DIRECTORY_SEPARATOR));
        $dirs = glob($baseDir . DIRECTORY_SEPARATOR . ltrim($pattern, DIRECTORY_SEPARATOR), GLOB_ONLYDIR | GLOB_NOSORT);

        $result = [];

        foreach ($dirs as $dir) {
            // 기준 디렉토리로부터의 상대 경로
            $relativeBase = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $dir);
            $result[] = $relativeBase;

            // 하위 디렉토리 모두 검색
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $path => $info) {
                if ($info->isDir()) {
                    $result[] = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $path);
                }
            }
        }

        // 중복 제거 및 정렬
        $result = array_unique($result);
        sort($result);

        return $result;
    }
}

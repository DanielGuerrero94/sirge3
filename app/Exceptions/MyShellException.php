<?php

namespace App\Exceptions;

use Exception;

class MyShellException extends \Exception {
	public static function execute($command, &$out = null) {
		if (func_num_args() > 1) {
			$desc[1] = ['pipe', 'w'];
		} else {
			$desc[1] = ['file', '/dev/null'];
		}

		$desc[2] = ['pipe', 'w'];

		$proc = proc_open($command, $desc, $pipes);
		if (is_resource($proc)) {
			if (isset($pipes[1])) {
				$out = stream_get_contents($pipes[1]);
				fclose($pipes[1]);
			}

			if ($err = stream_get_contents($pipes[2])) {
				fclose($pipes[2]);
				throw new MyShellException("Command $command failed: $err");
			}

			if ($exit_status = proc_close($proc)) {
				throw new MyShellException("Command $command exited with non-zero status");
			}
		}
	}
}

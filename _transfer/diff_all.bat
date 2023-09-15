:: ============================================================================
:: SourceTreeカスタム処理用バッチ（Windows）
:: 2コミット間の差分ファイルを出力する
:: カスタム処理のパラメータ指定に"$SHAが必要

@echo off
setlocal ENABLEDELAYEDEXPANSION


:: ------------------------------------------------------
:: bat処理本体
:: git.exeへのパス
set GIT_EXE=git
:: ..明示的に指定したい時はフルパス
:: set GIT_EXE=C:\PROGRA~2\Git\bin\git.exe

set NEW_SHA=%1
set OLD_SHA=%2

:: リポジトリの親フォルダを出力先とする
:: ..C:\etc\a.git -> c:\etc以下が出力先
set OUTPUT_DIR_ROOT=%~dp3

:: スペース区切りのファイル羅列文字列がこの文字数を超えたときcheckout-indexを実行する
:: ..コマンドラインの文字数制限の対応
:: ..https://support.microsoft.com/ja-jp/kb/830473
set /a CHECKOUT_FILE_CHAR_MAX=1000
:: 処理用一時変数
set /a CMD_LEN=0
set DIFF_LIST=""

:: 出力先フォルダ名
:: gitリポジトリと同階層に@archiveとして出力
set time2=%time: =0%
set OUTPUT_DIR_NAME=@archive
mkdir %OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME%

:: 出力処理開始
for /f "usebackq" %%A in (`%GIT_EXE% diff --name-only --diff-filter=AMDCR %OLD_SHA%..%NEW_SHA%`) do (
    call :FOR_PROC %%A "!DIFF_LIST!"
)
call :GIT_CHECKOUT_INDEX "!DIFF_LIST!"
:: 出力結果表示
echo ^^(*^^^^ _^ ^^^^*)^ sabun^^! to %OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME%

exit /b


:: ------------------------------------------------------
:: forループ内でgotoを使用するため分割した処理
:FOR_PROC
    :: 差分ファイル名の文字数計算
    set TMP_FILE_NAME=%1
    :LEN_LOOP
    if not "%TMP_FILE_NAME%"=="" (
        set TMP_FILE_NAME=%TMP_FILE_NAME:~1%
        set /a CMD_LEN=%CMD_LEN%+1
        goto LEN_LOOP
    )
    :: ファイル名の区切り文字（スペース1文字）分
    set /a CMD_LEN=%CMD_LEN%+1

    :: 一定文字数以上になった時点で都度出力
    if %CMD_LEN% LEQ %CHECKOUT_FILE_CHAR_MAX% (
        :: 変数で保持
        if !DIFF_LIST!=="" (
            set DIFF_LIST=%1
        ) else (
            set DIFF_LIST=!DIFF_LIST! %1
        )

    ) else (
        :: 出力
        set /a CMD_LEN=0
        call :GIT_CHECKOUT_INDEX "!DIFF_LIST!"
        set DIFF_LIST=%1
    )
exit /b


:: ------------------------------------------------------
:GIT_CHECKOUT_INDEX
    set TMP_CHECKOUT_LIST=%1
    :: 前後の"を除く
    set TMP_CHECKOUT_LIST=%TMP_CHECKOUT_LIST:~1%
    set TMP_CHECKOUT_LIST=%TMP_CHECKOUT_LIST:~-0,-1%

    %GIT_EXE% checkout-index --prefix=%OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME%\ -f %TMP_CHECKOUT_LIST%

exit /b

endlocal
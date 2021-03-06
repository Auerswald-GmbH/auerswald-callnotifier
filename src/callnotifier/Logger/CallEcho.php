<?php
namespace callnotifier;

class Logger_CallEcho extends Logger_CallBase
{
    public function log($type, $arData)
    {
        switch ($type) {
        case 'startingCall':
            $displayMethod = 'displayStart';
            break;
        case 'finishedCall':
            $displayMethod = 'displayFinished';
            break;
        default:
            return;
        }

        $call = $arData['call'];
        if (!$this->hasValidType($call)) {
            return;
        }
        if (!$this->hasValidMsn($call)) {
            return;
        }
        $this->$displayMethod($arData['call']);
    }


    protected function displayStart(CallMonitor_Call $call)
    {
        $this->addUnsetVars($call);
        echo 'Starting ' . $this->getTypeName($call)
            . ' call from ' . trim($this->getNumberString($call, 'from'))
            . ' to ' . trim($this->getNumberString($call, 'to')) . "\n";
    }

    protected function displayFinished(CallMonitor_Call $call)
    {
        $this->addUnsetVars($call);
        echo 'Finished ' . $this->getTypeName($call)
            . ' call from ' . trim($this->getNumberString($call, 'from'))
            . ' to ' . trim($this->getNumberString($call, 'to'))
            . ', length ' . date('H:i:s', $call->end - $call->start - 3600)
            . "\n";
    }

    protected function getTypeName($call)
    {
        return $call->type == CallMonitor_Call::INCOMING
            ? 'incoming' : 'outgoing';
    }
}
?>

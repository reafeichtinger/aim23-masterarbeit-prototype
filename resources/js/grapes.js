import createStudioEditor from '@grapesjs/studio-sdk';
import '@grapesjs/studio-sdk/style';
import { presetPrintable, canvasFullSize } from '@grapesjs/studio-sdk-plugins';

window.createStudioEditor = createStudioEditor;
window.presetPrintable = presetPrintable;
window.canvasFullSize = canvasFullSize;
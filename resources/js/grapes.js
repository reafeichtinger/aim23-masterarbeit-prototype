import createStudioEditor from '@grapesjs/studio-sdk';
import '@grapesjs/studio-sdk/style';
import { presetPrintable, canvasFullSize, tableComponent } from '@grapesjs/studio-sdk-plugins';

window.createStudioEditor = createStudioEditor;
window.presetPrintable = presetPrintable;
window.canvasFullSize = canvasFullSize;
window.tableComponent = tableComponent;
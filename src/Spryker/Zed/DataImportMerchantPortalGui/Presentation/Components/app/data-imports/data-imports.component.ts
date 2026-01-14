import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { TableConfig } from '@spryker/table';

@Component({
    standalone: false,
    selector: 'mp-data-imports',
    templateUrl: './data-imports.component.html',
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
})
export class DataImportsComponent {
    @Input() tableConfig: TableConfig;
    @Input() tableId?: string;
}

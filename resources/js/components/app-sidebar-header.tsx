import { SidebarTrigger } from '@/components/ui/sidebar';
import {useKnowledgeFiltersContext} from "@/context/KnowledgeFiltersContext";

export function AppSidebarHeader({ }) {
    const { selectedBrand, selectedModel, selectedModification } = useKnowledgeFiltersContext();
    console.log(selectedBrand, selectedModel, selectedModification);

    return (
        <header className="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/50 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
            <div className="flex items-center gap-2">
                <SidebarTrigger className="-ml-1" />
                {(selectedBrand || selectedModel || selectedModification)
                    ? (
                        <div
                            className="ml-4 text-sm font-medium whitespace-nowrap overflow-hidden text-ellipsis max-w-xs">
                            {selectedBrand?.name}
                            {selectedModel && ` / ${selectedModel.name}`}
                            {selectedModification && ` / ${selectedModification.name}`}
                        </div>
                    )
                    : 'Главная'
                }
            </div>
        </header>
    );
}

<?php

namespace elnebuloso\Phing\Entity\Versioning;

/**
 * Class GitVersion
 */
class GitVersion extends AbstractVersion implements Version
{
    /**
     * @var string
     */
    private string $PreReleaseTag;

    /**
     * @var string
     */
    private string $PreReleaseTagWithDash;

    /**
     * @var string
     */
    private string $PreReleaseLabel;

    /**
     * @var string
     */
    private string $PreReleaseNumber;

    /**
     * @var string
     */
    private string $WeightedPreReleaseNumber;

    /**
     * @var string
     */
    private string $BuildMetaData;

    /**
     * @var string
     */
    private string $BuildMetaDataPadded;

    /**
     * @var string
     */
    private string $FullBuildMetaData;

    /**
     * @var string
     */
    private string $MajorMinorPatch;

    /**
     * @var string
     */
    private string $SemVer;

    /**
     * @var string
     */
    private string $LegacySemVer;

    /**
     * @var string
     */
    private string $LegacySemVerPadded;

    /**
     * @var string
     */
    private string $AssemblySemVer;

    /**
     * @var string
     */
    private string $AssemblySemFileVer;

    /**
     * @var string
     */
    private string $FullSemVer;

    /**
     * @var string
     */
    private string $InformationalVersion;

    /**
     * @var string
     */
    private string $BranchName;

    /**
     * @var string
     */
    private string $Sha;

    /**
     * @var string
     */
    private string $ShortSha;

    /**
     * @var string
     */
    private string $NuGetVersionV2;

    /**
     * @var string
     */
    private string $NuGetVersion;

    /**
     * @var string
     */
    private string $NuGetPreReleaseTagV2;

    /**
     * @var string
     */
    private string $NuGetPreReleaseTag;

    /**
     * @var string
     */
    private string $VersionSourceSha;

    /**
     * @var string
     */
    private string $CommitsSinceVersionSource;

    /**
     * @var string
     */
    private string $CommitsSinceVersionSourcePadded;

    /**
     * @var string
     */
    private string $CommitDate;

    /**
     * @return string
     */
    public function getPreReleaseTag(): string
    {
        return $this->PreReleaseTag;
    }

    /**
     * @param string $PreReleaseTag
     */
    public function setPreReleaseTag(string $PreReleaseTag): void
    {
        $this->PreReleaseTag = $PreReleaseTag;
    }

    /**
     * @return string
     */
    public function getPreReleaseTagWithDash(): string
    {
        return $this->PreReleaseTagWithDash;
    }

    /**
     * @param string $PreReleaseTagWithDash
     */
    public function setPreReleaseTagWithDash(string $PreReleaseTagWithDash): void
    {
        $this->PreReleaseTagWithDash = $PreReleaseTagWithDash;
    }

    /**
     * @return string
     */
    public function getPreReleaseLabel(): string
    {
        return $this->PreReleaseLabel;
    }

    /**
     * @param string $PreReleaseLabel
     */
    public function setPreReleaseLabel(string $PreReleaseLabel): void
    {
        $this->PreReleaseLabel = $PreReleaseLabel;
    }

    /**
     * @return string
     */
    public function getPreReleaseNumber(): string
    {
        return $this->PreReleaseNumber;
    }

    /**
     * @param string $PreReleaseNumber
     */
    public function setPreReleaseNumber(string $PreReleaseNumber): void
    {
        $this->PreReleaseNumber = $PreReleaseNumber;
    }

    /**
     * @return string
     */
    public function getWeightedPreReleaseNumber(): string
    {
        return $this->WeightedPreReleaseNumber;
    }

    /**
     * @param string $WeightedPreReleaseNumber
     */
    public function setWeightedPreReleaseNumber(string $WeightedPreReleaseNumber): void
    {
        $this->WeightedPreReleaseNumber = $WeightedPreReleaseNumber;
    }

    /**
     * @return string
     */
    public function getBuildMetaData(): string
    {
        return $this->BuildMetaData;
    }

    /**
     * @param string $BuildMetaData
     */
    public function setBuildMetaData(string $BuildMetaData): void
    {
        $this->BuildMetaData = $BuildMetaData;
    }

    /**
     * @return string
     */
    public function getBuildMetaDataPadded(): string
    {
        return $this->BuildMetaDataPadded;
    }

    /**
     * @param string $BuildMetaDataPadded
     */
    public function setBuildMetaDataPadded(string $BuildMetaDataPadded): void
    {
        $this->BuildMetaDataPadded = $BuildMetaDataPadded;
    }

    /**
     * @return string
     */
    public function getFullBuildMetaData(): string
    {
        return $this->FullBuildMetaData;
    }

    /**
     * @param string $FullBuildMetaData
     */
    public function setFullBuildMetaData(string $FullBuildMetaData): void
    {
        $this->FullBuildMetaData = $FullBuildMetaData;
    }

    /**
     * @return string
     */
    public function getMajorMinorPatch(): string
    {
        return $this->MajorMinorPatch;
    }

    /**
     * @param string $MajorMinorPatch
     */
    public function setMajorMinorPatch(string $MajorMinorPatch): void
    {
        $this->MajorMinorPatch = $MajorMinorPatch;
    }

    /**
     * @return string
     */
    public function getSemVer(): string
    {
        return $this->SemVer;
    }

    /**
     * @param string $SemVer
     */
    public function setSemVer(string $SemVer): void
    {
        $this->SemVer = $SemVer;
    }

    /**
     * @return string
     */
    public function getLegacySemVer(): string
    {
        return $this->LegacySemVer;
    }

    /**
     * @param string $LegacySemVer
     */
    public function setLegacySemVer(string $LegacySemVer): void
    {
        $this->LegacySemVer = $LegacySemVer;
    }

    /**
     * @return string
     */
    public function getLegacySemVerPadded(): string
    {
        return $this->LegacySemVerPadded;
    }

    /**
     * @param string $LegacySemVerPadded
     */
    public function setLegacySemVerPadded(string $LegacySemVerPadded): void
    {
        $this->LegacySemVerPadded = $LegacySemVerPadded;
    }

    /**
     * @return string
     */
    public function getAssemblySemVer(): string
    {
        return $this->AssemblySemVer;
    }

    /**
     * @param string $AssemblySemVer
     */
    public function setAssemblySemVer(string $AssemblySemVer): void
    {
        $this->AssemblySemVer = $AssemblySemVer;
    }

    /**
     * @return string
     */
    public function getAssemblySemFileVer(): string
    {
        return $this->AssemblySemFileVer;
    }

    /**
     * @param string $AssemblySemFileVer
     */
    public function setAssemblySemFileVer(string $AssemblySemFileVer): void
    {
        $this->AssemblySemFileVer = $AssemblySemFileVer;
    }

    /**
     * @return string
     */
    public function getFullSemVer(): string
    {
        return $this->FullSemVer;
    }

    /**
     * @param string $FullSemVer
     */
    public function setFullSemVer(string $FullSemVer): void
    {
        $this->FullSemVer = $FullSemVer;
    }

    /**
     * @return string
     */
    public function getInformationalVersion(): string
    {
        return $this->InformationalVersion;
    }

    /**
     * @param string $InformationalVersion
     */
    public function setInformationalVersion(string $InformationalVersion): void
    {
        $this->InformationalVersion = $InformationalVersion;
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->BranchName;
    }

    /**
     * @param string $BranchName
     */
    public function setBranchName(string $BranchName): void
    {
        $this->BranchName = $BranchName;
    }

    /**
     * @return string
     */
    public function getSha(): string
    {
        return $this->Sha;
    }

    /**
     * @param string $Sha
     */
    public function setSha(string $Sha): void
    {
        $this->Sha = $Sha;
    }

    /**
     * @return string
     */
    public function getShortSha(): string
    {
        return $this->ShortSha;
    }

    /**
     * @param string $ShortSha
     */
    public function setShortSha(string $ShortSha): void
    {
        $this->ShortSha = $ShortSha;
    }

    /**
     * @return string
     */
    public function getNuGetVersionV2(): string
    {
        return $this->NuGetVersionV2;
    }

    /**
     * @param string $NuGetVersionV2
     */
    public function setNuGetVersionV2(string $NuGetVersionV2): void
    {
        $this->NuGetVersionV2 = $NuGetVersionV2;
    }

    /**
     * @return string
     */
    public function getNuGetVersion(): string
    {
        return $this->NuGetVersion;
    }

    /**
     * @param string $NuGetVersion
     */
    public function setNuGetVersion(string $NuGetVersion): void
    {
        $this->NuGetVersion = $NuGetVersion;
    }

    /**
     * @return string
     */
    public function getNuGetPreReleaseTagV2(): string
    {
        return $this->NuGetPreReleaseTagV2;
    }

    /**
     * @param string $NuGetPreReleaseTagV2
     */
    public function setNuGetPreReleaseTagV2(string $NuGetPreReleaseTagV2): void
    {
        $this->NuGetPreReleaseTagV2 = $NuGetPreReleaseTagV2;
    }

    /**
     * @return string
     */
    public function getNuGetPreReleaseTag(): string
    {
        return $this->NuGetPreReleaseTag;
    }

    /**
     * @param string $NuGetPreReleaseTag
     */
    public function setNuGetPreReleaseTag(string $NuGetPreReleaseTag): void
    {
        $this->NuGetPreReleaseTag = $NuGetPreReleaseTag;
    }

    /**
     * @return string
     */
    public function getVersionSourceSha(): string
    {
        return $this->VersionSourceSha;
    }

    /**
     * @param string $VersionSourceSha
     */
    public function setVersionSourceSha(string $VersionSourceSha): void
    {
        $this->VersionSourceSha = $VersionSourceSha;
    }

    /**
     * @return string
     */
    public function getCommitsSinceVersionSource(): string
    {
        return $this->CommitsSinceVersionSource;
    }

    /**
     * @param string $CommitsSinceVersionSource
     */
    public function setCommitsSinceVersionSource(string $CommitsSinceVersionSource): void
    {
        $this->CommitsSinceVersionSource = $CommitsSinceVersionSource;
    }

    /**
     * @return string
     */
    public function getCommitsSinceVersionSourcePadded(): string
    {
        return $this->CommitsSinceVersionSourcePadded;
    }

    /**
     * @param string $CommitsSinceVersionSourcePadded
     */
    public function setCommitsSinceVersionSourcePadded(string $CommitsSinceVersionSourcePadded): void
    {
        $this->CommitsSinceVersionSourcePadded = $CommitsSinceVersionSourcePadded;
    }

    /**
     * @return string
     */
    public function getCommitDate(): string
    {
        return $this->CommitDate;
    }

    /**
     * @param string $CommitDate
     */
    public function setCommitDate(string $CommitDate): void
    {
        $this->CommitDate = $CommitDate;
    }
}
